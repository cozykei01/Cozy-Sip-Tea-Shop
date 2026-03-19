<?php

require_once '../app/models/Exchange.php';

class ExchangeController {
    private $exchangeModel;

    public function __construct($db) {
        $this->exchangeModel = new Exchange($db);
    }

    /**
     * Handle the exchange request via POST.
     */
    public function process() {
        // 1. Method check
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        // 2. Auth check
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please login to continue exchange.']);
            return;
        }

        // 3. Get input
        $input = json_decode(file_get_contents('php://input'), true);
        $exchangeCart = $input['exchangeCart'] ?? [];
        $userId = $_SESSION['user_id'];

        if (empty($exchangeCart)) {
            echo json_encode(['success' => false, 'message' => 'Your exchange list is empty.']);
            return;
        }

        // 4. Process transaction
        $result = $this->exchangeModel->processExchange($userId, $exchangeCart);

        if ($result === true) {
            // Create notification
            require_once '../app/models/Notification.php';
            $notification = new Notification($this->exchangeModel->getConnection());
            
            $totalPoints = 0;
            foreach ($exchangeCart as $item) {
                $totalPoints += ($item['points'] * $item['quantity']);
            }
            
            $notification->create(
                $userId, 
                "Exchange Successful", 
                "You have successfully exchanged " . number_format($totalPoints) . " points for " . count($exchangeCart) . " item(s)."
            );

            // Update session points for real-time display in navbar
            $newPoints = $this->exchangeModel->getUserPoints($userId);
            $_SESSION['user_points'] = $newPoints;

            echo json_encode([
                'success' => true,
                'message' => 'Exchange completed successfully!',
                'newPoints' => $newPoints,
                'unread_count' => $notification->countUnread($userId)
            ]);
        } else {
            // $result contains the error message string
            echo json_encode([
                'success' => false,
                'message' => 'Exchange failed: ' . $result
            ]);
        }
    }
}
