const http = require('http');
const socketIo = require('socket.io');
const cors = require('cors');
const express = require('express');

const app = express();
app.use(cors()); // Mengizinkan semua origin, Anda bisa mempersempit jika perlu

const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "http://cbt-online.devs", // Ganti dengan domain Anda
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log('A user connected');
    
    socket.on('refresh-page', (data) => {
        console.log('Refreshing page for user:', data.userId);
        io.to(data.userId).emit('refresh');
    });
    
    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

server.listen(3000, () => {
    console.log('Server is running on port 3000');
});