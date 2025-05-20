const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');

const app = express();
app.use(bodyParser.json());

// MySQL database connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',          // Change as needed
    password: '',           // Add your MySQL password
    database: 'travel'
});

db.connect(err => {
    if (err) {
        console.error('Error connecting to the database:', err);
        return;
    }
    console.log('Connected to the database');
});

// Payment API
app.post('/payment', (req, res) => {
    const { userId, amount, paymentMethod } = req.body;

    // Insert payment entry in database
    const query = 'INSERT INTO paymentss (user_id, amount, payment_method, status) VALUES (?, ?, ?, ?)';
    db.query(query, [userId, amount, paymentMethod, 'pending'], (err, result) => {
        if (err) {
            return res.status(500).send({ message: 'Database error', error: err });
        }

        const paymentId = result.insertId;

        // Simulate payment processing and update status
        const updateQuery = 'UPDATE payments SET status = ? WHERE payment_id = ?';
        db.query(updateQuery, ['completed', paymentId], (err) => {
            if (err) {
                return res.status(500).send({ message: 'Error updating payment status', error: err });
            }

            // Record transaction
            const transactionQuery = 'INSERT INTO transactionss (payment_id, status) VALUES (?, ?)';
            db.query(transactionQuery, [paymentId, 'successful'], (err) => {
                if (err) {
                    return res.status(500).send({ message: 'Error recording transaction', error: err });
                }

                res.send({ message: 'Payment successful', paymentId });
            });
        });
    });
});

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
