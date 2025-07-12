const express = require('express');
const cors = require('cors');
const StudentChatbot = require('./chatbot');

const app = express();
const chatbot = new StudentChatbot();

app.use(cors());
app.use(express.json());

app.post('/api/chat', (req, res) => {
  const { message } = req.body;
  const response = chatbot.getResponse(message);
  res.json({ response });
});

const PORT = 3001;
app.listen(PORT, () => {
  console.log(`🤖 Chatbot API running at https://maceer.systems:${PORT}`);
});
