<!DOCTYPE html>
<html>
<head>
    <title>404 - Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        
        .error-container {
            text-align: center;
        }
        
        .error-image {
            max-width: 80%;
            height: auto;
            animation: 
                float 4s ease-in-out infinite,
                bounce 5s ease infinite;
        }
        
        .error-text {
            margin-top: 20px;
            font-size: 24px;
            color: #333;
            opacity: 0;
            animation: fadeIn 1s ease 1s forwards;
        }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        /* Occasional bounce */
        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0) scale(1); }
            30% { transform: translateY(-30px) scale(1.1); }
            45% { transform: translateY(0) scale(0.95); }
        }
        
        /* Fade in for text */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <img src="/views/assets/modules/img/logo/404.png" alt="Page not found" class="error-image">
        <div class="error-text">Oops! The page you're looking for doesn't exist.</div>
    </div>
</body>
</html>