    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .home-container {
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
            padding: 20px;
        }
        .home-text-center {
            text-align: center;
            margin-bottom: 5px;
        }

        .home-text-center h2 {
            color: #8B0000;
            font-size: 32px;
            margin-bottom: 15px; /* Margin kept for the first paragraph */
        }
        .search {
            margin: 3px auto 10px auto; /* Reduced top margin (from 20px → 5px) */
            text-align: center;
            width: 100%;
        }

        .search-form {
            width: 100%;
            max-width: 500px;
            padding: 12px 20px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 25px;
            outline: none;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .search-form:focus {
            border-color: #8B0000;
            box-shadow: 0 2px 10px rgba(139, 0, 0, 0.2);
        }

        .search-form::placeholder {
            color: #888;
            font-style: italic;
        }
        
        .card-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
        }

        .card-container {
            width: 100%;
            max-width: 400px;
            min-height: 280px;
            position: relative;
        }
        .card {
            background-color: white;
            border: 2px solid #c29292;
            border-radius: 10px;
            padding: 25px;
            transition: transform 0.5s ease, opacity 0.5s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateX(100%);
            position: absolute;
            width: 100%;
            box-sizing: border-box;
            box-shadow: none;
            top: 0;
            left: 0;
            height: 380px; /* Increased from original */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* This will push button to bottom */
        }

        .card.active {
            transform: translateX(0);
            opacity: 1;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .card h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 15px;
            color: #555;
        }
        .card a {
            display: block;
            margin: 0 auto; /* Centers horizontally */
            width: fit-content;
            color: #8B0000;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            background-color: #f8f9fa;
            transition: all 0.3s;
            border: 1px solid #8B0000;
            text-align: center; /* Ensures text stays centered */
        }

        .card a:hover {
            background-color: #8B0000;
            color: white;
        }
        
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #8B0000;
            color: white;
            border: none;
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }
        
        .nav-btn:hover {
            background-color: #cc0000;
            transform: translateY(-50%) scale(1.1);
        }
        
        #prevBtn {
            left: -25px;
        }
        
        #nextBtn {
            right: -25px;
        }

        .text-danger {
            color: #cc0000;
            font-weight: bold;
        }
    </style>
    <?php
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    ?>
    <div class="home-container">
        <div class="home-text-center">
            <h2>Welcome to Dashboard!</h2>
        </div>

        <div class="search">
            <input type="text" class="search-form" placeholder="Search a class or program">
        </div>

        <div class="card-wrapper">
            <button id="prevBtn" class="nav-btn">&lt;</button>

            <div class="card-container">
                <div class="card active">
                    <h5>Course & Program</h5>
                    <p>BSIT 1 - Prog 2</p>
                    <h5>Number of Students</h5>
                    <p>50</p>
                    <h5>Status</h5>
                    <p class="text-danger">Incomplete Data</p>
                    <a href="index.php?page=">View Class</a>
                </div>
                <div class="card">
                    <h5>Course & Program</h5>
                    <p>BSIT 2 - OOP</p>
                    <h5>Number of Students</h5>
                    <p>50</p>
                    <h5>Status</h5>
                    <p class="text-danger">Incomplete Data</p>
                    <a href="#">View Class</a>
                </div>
                <div class="card">
                    <h5>Course & Program</h5>
                    <p>DIT 1 - Prog 2</p>
                    <h5>Number of Students</h5>
                    <p>50</p>
                    <h5>Status</h5>
                    <p class="text-danger">Incomplete Data</p>
                    <a href="#">View Class</a>
                </div>
                <div class="card">
                    <h5>Course & Program</h5>
                    <p>DIT 2 - OOP</p>
                    <h5>Number of Students</h5>
                    <p>50</p>
                    <h5>Status</h5>
                    <p class="text-danger">Incomplete Data</p>
                    <a href="#">View Class</a>
                </div>
            </div>

            <button id="nextBtn" class="nav-btn">&gt;</button>
        </div>
    <script>
        const cards = document.querySelectorAll('.card');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let current = 0;

        function showCard(next) {
            if (next === current) return;

            const direction = next > current ? 1 : -1;

            // Animate out current card
            const currentCard = cards[current];
            currentCard.style.transform = `translateX(${direction * -100}%)`;
            currentCard.style.opacity = '0';
            currentCard.classList.remove('active');

            // Prepare and show next card
            const nextCard = cards[next];
            nextCard.style.transform = `translateX(${direction * 100}%)`;
            nextCard.style.opacity = '0';
            nextCard.classList.add('active');

            requestAnimationFrame(() => {
                nextCard.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
                nextCard.style.transform = 'translateX(0)';
                nextCard.style.opacity = '1';
            });

            current = next;
        }

        prevBtn.addEventListener('click', () => {
            const nextIndex = (current - 1 + cards.length) % cards.length;
            showCard(nextIndex);
        });

        nextBtn.addEventListener('click', () => {
            const nextIndex = (current + 1) % cards.length;
            showCard(nextIndex);
        });

        // Auto-rotate cards every 5 seconds
        setInterval(() => {
            const nextIndex = (current + 1) % cards.length;
            showCard(nextIndex);
        }, 5000);
    </script>
</body>
</html>
