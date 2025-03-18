<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileForge</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .hero-image {
            background-image: url('homepage.jpeg');
            background-size: cover;
            background-position: center;
            height: 115vh; /* Adjust the height as needed */
        }
        /* Custom styles for added sections */
        .section {
            padding: 5rem 0;
        }
        .section-heading {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInDown 1s ease-out;
        }
        .section-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: #f7f7f7;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeInUp 1s ease-out;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card img {
            max-width: 100%;
            border-radius: 0.5rem;
        }
        .card h3 {
            margin-top: 1.5rem;
            font-size: 1.5rem;
        }
        .card p {
            margin-top: 0.5rem;
        }
        /* Keyframe animations */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">FileForge</h1>
            <div>
                <a href="login.php" class="text-white mr-4 hover:text-gray-300 transition duration-300">Login</a>
                <a href="signup.php" class="text-white hover:text-gray-300 transition duration-300">Signup</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-image flex items-center justify-center text-center text-white">
    </header>

    <!-- Main Content Sections -->
    <main>
        <!-- About Section -->
        <section class="section bg-gray-100">
            <div class="container mx-auto">
                <h2 class="section-heading">About Us</h2>
                <div class="section-content">
                    <div class="card">
                        <img src="https://img.freepik.com/free-photo/business-strategy-success-target-goals_1421-33.jpg?w=900&t=st=1712286279~exp=1712286879~hmac=7b84b2ce7c44c0fa7c15143d154a610e4ffb557d73303b09832bc6cbc73f1197" alt="About Image 1">
                        <h3>Our Mission</h3>
                        <p>Users can securely store and share their data with confidence, knowing that their information is protected against unauthorized access and interception while enjoying the convenience of instant sharing and collaboration.</p>
                    </div>
                    <div class="card">
                        <img src="https://img.freepik.com/free-vector/businessmen-run-their-business-with-visionary-vision-work-bring-company-top-market-beating-competition-no-1-position_24797-2308.jpg?w=996" alt="About Image 2">
                        <h3>Our Vision</h3>
                        <p>By incorporating these strategies into the development of your web application, users will have a reliable and scalable platform for storing and managing large datasets securely and efficiently.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section class="section">
            <div class="container mx-auto">
                <h2 class="section-heading">Key Features</h2>
                <div class="section-content">
                    <div class="card">
                        <img src="https://img.freepik.com/free-vector/deadline-concept-illustration_114360-6003.jpg?w=740" alt="Feature Image 1">
                        <h3>Instant</h3>
                        <p>Quick Sharing using QR codes</p>
                    </div>
                    <div class="card">
                        <img src="https://img.freepik.com/free-vector/connected-concept-illustration_114360-482.jpg?w=740" alt="Feature Image 2">
                        <h3>File Sharing</h3>
                        <p>Better, Easy and Fast Sharing</p>
                    </div>
                    <div class="card">
                        <img src="/php_project/Secure data-cuate.png" alt="Feature Image 3">
                        <h3>Security</h3>
                        <p>Secure data storage</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-200 py-4 mt-8">
        <div class="container mx-auto text-center">
            <p class="text-gray-600">Copyright &copy; 2023</p>
        </div>
    </footer>
</body>
</html>
