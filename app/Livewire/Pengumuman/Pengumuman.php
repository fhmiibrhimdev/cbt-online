<?php

namespace App\Livewire\Pengumuman;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\RunningText;
use App\Models\PostComments;
use App\Helpers\GlobalHelper;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Pengumuman extends Component
{
    #[Title('Pengumuman')]

    protected $listeners = [
        'delete'
    ];

    public $text = [], $kepada = [], $kelases;
    public $text_posts = "";
    public $showKelasOptions = true, $showSiswaOption = true;
    public $comment;
    public $dataId, $mode;
    public $postIdWithComments = [];
    public $id_tp, $id_smt;

    public function mount()
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $this->text    = RunningText::pluck('text', 'id')->toArray();
        $this->kelases  = DB::table('kelas')->select('kelas.id', 'kode_kelas', 'level')->leftJoin('level', 'level.id', 'kelas.id_level')->where('id_tp', $this->id_tp)->get()->groupBy('level');

        $this->dispatch('initSummernote');
        $this->dispatch('initSelect2');
    }

    public function toggleComments($postId)
    {
        if (in_array($postId, $this->postIdWithComments)) {
            $this->postIdWithComments = array_diff($this->postIdWithComments, [$postId]);
        } else {
            $this->postIdWithComments[] = $postId;
        }

        $this->dispatch('initSummernote');
        $this->dispatch('initSelect2');
    }

    public function render()
    {
        Carbon::setLocale('id');

        $posts = Post::select('posts.*', DB::raw('COUNT(post_comments.id) as comments_count'), 'users.name')
            ->join('users', 'posts.id_user', '=', 'users.id')
            ->leftJoin('post_comments', 'posts.id', '=', 'post_comments.id_post')
            ->groupBy('posts.id')
            ->paginate();

        $comments = PostComments::select('post_comments.*', 'users.name')
            ->join('users', 'post_comments.id_user', '=', 'users.id')
            ->whereIn('post_comments.id_post', $this->postIdWithComments)
            ->get()
            ->groupBy('id_post');

        return view('livewire.pengumuman.pengumuman', [
            'posts' => $posts,
            'comments' => $comments,
        ]);
    }

    public function updatedKepada()
    {
        if (in_array('siswa', $this->kepada)) {
            $this->showKelasOptions = false;
        } else {
            $this->showKelasOptions = true;
        }

        if (array_intersect($this->kepada, $this->kelases->pluck('id')->toArray())) {
            $this->showSiswaOption = false;
        } else {
            $this->showSiswaOption = true;
        }
    }

    public function updated()
    {
        $this->dispatch('initSelect2');
    }

    public function store()
    {
        Post::create([
            'id_user' => Auth::user()->id,
            'kepada'  => implode(',', $this->kepada),
            'text'    => $this->text_posts,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function storeComment($id)
    {
        PostComments::create([
            'id_post' => $id,
            'id_user' => Auth::user()->id,
            'text'    => $this->comment,
        ]);
        $this->comment = '';
    }

    public function update()
    {
        foreach ($this->text as $key => $value) {
            RunningText::where('id', $key)->update(['text' => $value]);
        }

        $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
        $this->dispatch('initSummernote');
        $this->dispatch('initSelect2');
    }

    public function deleteConfirm($id, $mode)
    {
        $this->dataId = $id;
        $this->mode = $mode;
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',
            'message'   => 'Are you sure?',
            'text'      => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {
        if ($this->mode == "post") {
            Post::findOrFail($this->dataId)->delete();
            PostComments::where('id_post', $this->dataId)->delete();
        } elseif ($this->mode == "comment") {
            PostComments::findOrFail($this->dataId)->delete();
        }
        $this->dispatch('initSummernote');
        $this->dispatch('initSelect2');
    }
}
