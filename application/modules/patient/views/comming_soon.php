<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - Klinicx Healthcare</title>
	<?php 
    if($this->ion_auth->in_group('admin')){ 
    if($this->settings->dashboard_theme == 'main'){ ?>
		<style>
        .coming-soon-container {
            min-height: 100vh;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .polygon-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxwb2x5Z29uIHBvaW50cz0iMCwwIDIwLDAgMjAsMjAgMCwyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.3;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            width: 100%;
        }

        .logoo {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown {
			
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 60px 0;
            width: 100%;
            max-width: 800px;
        }

        .countdown-item {
            background: rgba(255,255,255,0.15);
            padding: 30px;
            border-radius: 15px;
            min-width: 120px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-5px);
        }

        .countdown-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown-label {
            font-size: 14px;
            text-transform: uppercase;
        }

        .subscribe-form {
			
            margin-bottom: 40px;
        }

        .subscribe-form input {
            padding: 15px;
            width: 300px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
        }

        .subscribe-btn {
            padding: 15px 30px;
            background: #fff;
            color: #ff6b6b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .subscribe-btn:hover {
            transform: scale(1.05);
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icons a {
            color: white;
            font-size: 24px;
            transition: transform 0.2s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .countdown {
                flex-wrap: wrap;
                gap: 15px;
                padding: 0 10px;
            }
            .countdown-item {
                min-width: 100px;
                padding: 20px;
            }
            .countdown-number {
                font-size: 36px;
            }
            .subscribe-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .subscribe-form input {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
<?php }else{ ?>
	<style>
        .coming-soon-container {
            min-height: 100vh;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .polygon-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxwb2x5Z29uIHBvaW50cz0iMCwwIDIwLDAgMjAsMjAgMCwyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.3;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            width: 100%;
        }

        .logoo {
			margin-left: 100px !important;
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown {
			margin-left: 100px !important;
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 60px 0;
            width: 100%;
            max-width: 800px;
        }

        .countdown-item {
            background: rgba(255,255,255,0.15);
            padding: 30px;
            border-radius: 15px;
            min-width: 120px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-5px);
        }

        .countdown-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown-label {
            font-size: 14px;
            text-transform: uppercase;
        }

        .subscribe-form {
			margin-left: 200px;
            margin-bottom: 40px;
        }

        .subscribe-form input {
            padding: 15px;
            width: 300px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
        }

        .subscribe-btn {
            padding: 15px 30px;
            background: #fff;
            color: #ff6b6b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .subscribe-btn:hover {
            transform: scale(1.05);
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icons a {
            color: white;
            font-size: 24px;
            transition: transform 0.2s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .countdown {
                flex-wrap: wrap;
                gap: 15px;
                padding: 0 10px;
            }
            .countdown-item {
                min-width: 100px;
                padding: 20px;
            }
            .countdown-number {
                font-size: 36px;
            }
            .subscribe-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .subscribe-form input {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
<?php } } ?>

<?php if($this->ion_auth->in_group('Patient')){  
    $current_user_id = $this->ion_auth->user()->row()->id;
    $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
    $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
    $group_name = strtolower($group_name);
    $user_theme = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->dashboard_theme;
    if($user_theme == 'main'){ ?>
		<style>
        .coming-soon-container {
            min-height: 100vh;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .polygon-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxwb2x5Z29uIHBvaW50cz0iMCwwIDIwLDAgMjAsMjAgMCwyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.3;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            width: 100%;
        }

        .logoo {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown {
			
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 60px 0;
            width: 100%;
            max-width: 800px;
        }

        .countdown-item {
            background: rgba(255,255,255,0.15);
            padding: 30px;
            border-radius: 15px;
            min-width: 120px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-5px);
        }

        .countdown-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown-label {
            font-size: 14px;
            text-transform: uppercase;
        }

        .subscribe-form {
			
            margin-bottom: 40px;
        }

        .subscribe-form input {
            padding: 15px;
            width: 300px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
        }

        .subscribe-btn {
            padding: 15px 30px;
            background: #fff;
            color: #ff6b6b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .subscribe-btn:hover {
            transform: scale(1.05);
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icons a {
            color: white;
            font-size: 24px;
            transition: transform 0.2s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .countdown {
                flex-wrap: wrap;
                gap: 15px;
                padding: 0 10px;
            }
            .countdown-item {
                min-width: 100px;
                padding: 20px;
            }
            .countdown-number {
                font-size: 36px;
            }
            .subscribe-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .subscribe-form input {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
<?php }else{ ?>
	<style>
        .coming-soon-container {
            min-height: 100vh;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .polygon-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxwb2x5Z29uIHBvaW50cz0iMCwwIDIwLDAgMjAsMjAgMCwyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.3;
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            width: 100%;
        }

        .logoo {
			margin-left: 100px !important;
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown {
			margin-left: 100px !important;
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 60px 0;
            width: 100%;
            max-width: 800px;
        }

        .countdown-item {
            background: rgba(255,255,255,0.15);
            padding: 30px;
            border-radius: 15px;
            min-width: 120px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .countdown-item:hover {
            transform: translateY(-5px);
        }

        .countdown-number {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .countdown-label {
            font-size: 14px;
            text-transform: uppercase;
        }

        .subscribe-form {
			margin-left: 200px;
            margin-bottom: 40px;
        }

        .subscribe-form input {
            padding: 15px;
            width: 300px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
        }

        .subscribe-btn {
            padding: 15px 30px;
            background: #fff;
            color: #ff6b6b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .subscribe-btn:hover {
            transform: scale(1.05);
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icons a {
            color: white;
            font-size: 24px;
            transition: transform 0.2s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .countdown {
                flex-wrap: wrap;
                gap: 15px;
                padding: 0 10px;
            }
            .countdown-item {
                min-width: 100px;
                padding: 20px;
            }
            .countdown-number {
                font-size: 36px;
            }
            .subscribe-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .subscribe-form input {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
<?php } } ?>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="coming-soon-container content-wrapper">
        <div class="polygon-bg"></div>
        <div class="content">
            <div class="logoo">COMING SOON</div>
            
            <div class="countdown">
                <div class="countdown-item">
                    <div id="days" class="countdown-number">0</div>
                    <div class="countdown-label">days</div>
                </div>
                <div class="countdown-item">
                    <div id="hours" class="countdown-number">0</div>
                    <div class="countdown-label">hours</div>
                </div>
                <div class="countdown-item">
                    <div id="minutes" class="countdown-number">0</div>
                    <div class="countdown-label">minutes</div>
                </div>
                <div class="countdown-item">
                    <div id="seconds" class="countdown-number">0</div>
                    <div class="countdown-label">seconds</div>
                </div>
            </div>

            <div class="subscribe-form">
                <input type="email" placeholder="Enter your email" id="email">
                <button class="subscribe-btn">Subscribe!</button>
            </div>

            
        </div>
    </div>

    <script>
        // Set the launch date (1 year from now)
        const launchDate = new Date();
        launchDate.setFullYear(launchDate.getFullYear() + 1);

        function updateCountdown() {
            const now = new Date();
            const distance = launchDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        // Update countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call

        // Handle form submission
        document.querySelector('.subscribe-btn').addEventListener('click', function() {
            const email = document.getElementById('email').value;
            if (email && email.includes('@')) {
                alert('Thank you for subscribing! We will notify you when we launch.');
                document.getElementById('email').value = '';
            } else {
                alert('Please enter a valid email address.');
            }
        });
    </script>
</body>
</html>