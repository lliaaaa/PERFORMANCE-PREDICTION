<style>
    .home-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 90vh;
    }

    .home-text-center {
        text-align: center;
    }

    .home-text-center h2 {
        color: #8B0000;
        font-size: 32px;
    }

    .search {
        margin: 20px auto;
        text-align: center;
    }

    .search-form {
        width: 100%;
        max-width: 400px;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 10px;
        outline: none;
        transition: border-color 0.3s;
    }

    .search-form:focus {
        border-color: #8B0000;
    }

    .search-form::placeholder {
        color: #888;
        font-style: italic;
    }

    .card-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        position: relative;
        min-height: 50vh;
        width: 70vh;
    }

    .nav-btn {
        background-color: #8B0000;
        color: white;
        border: none;
        font-size: 24px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-btn:hover {
        background-color: #cc0000;
        transform: scale(1.1);
    }

    .prev-btn {
        position: absolute;
        left: -60px;
    }

    .next-btn {
        position: absolute;
        right: -60px;
    }

    .card {
        background-color: white;
        border: 2px solid #c29292;
        border-radius: 10px;
        padding: 20px;
        width: 320px;
        transition: box-shadow 0.3s ease, transform 0.2s ease;
        display: none;
    }

    .card.active {
        display: block;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.5);
    }

    .card h5 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .card a {
        display: inline-block;
        margin-top: 10px;
        color: #8B0000;
        text-decoration: none;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 5px;
        background-color: #f8f9fa;
    }

    .card a:hover {
        background-color: #cc0000;
        color: white;
    }

    .text-danger {
        color: red;
        font-weight: bold;
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    .action-buttons button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #8B0000;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .action-buttons button:hover {
        background-color: #cc0000;
    }
</style>
<div class="home-container">
        <div class="home-text-center">
            <h2>Welcome to Dashboard!</h2>
            <p>You are managing 3 classes this semester.</p>
        </div>

        <div class="search">
            <input type="text" class="search-form" placeholder="Search a class or program">
        </div>

        <div class="card-container">
            <button id="prevBtn" class="nav-btn prev-btn">&lt;</button>

            <!-- Card Slides -->
            <div class="card active">
                <h5>Course & Program</h5>
                <p>BSIT 1 - Prog 2</p>
                <h5>Number of Students</h5>
                <p>50</p>
                <h5>Status</h5>
                <p class="text-danger">Incomplete Data</p>
                <a href="#">View Class</a>
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

            <button id="nextBtn" class="nav-btn next-btn">&gt;</button>
        </div>

        <div class="action-buttons">
            <button>View Student List</button>
            <button>Encode Grades</button>
            <button>Record Attendance</button>
            <button>Score Participation</button>
            <button>Generate Report</button>
        </div>
    </div>

    <!-- JS logic -->
    <script>
        const cards = document.querySelectorAll('.card');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let current = 0;

        function showCard(index) {
            cards.forEach((card, i) => {
                card.classList.toggle('active', i === index);
            });
        }

        prevBtn.addEventListener('click', () => {
            current = (current - 1 + cards.length) % cards.length;
            showCard(current);
        });

        nextBtn.addEventListener('click', () => {
            current = (current + 1) % cards.length;
            showCard(current);
        });
    </script>
