<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Landing Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .hero {
            background: url('{{ asset('images/unsada.jpeg') }}') no-repeat center center;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .feature-icon {
            font-size: 50px;
            color: #007bff;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">FinanceCo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonials">Testimonials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>Welcome to FinanceCo</h1>
            <p>Your partner in financial success.</p>
            <a href="#contact" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container my-5" id="features">
        <h2 class="text-center">Our Features</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="feature-icon">💼</div>
                <h3>Investment Management</h3>
                <p>Expert advice to grow your wealth.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="feature-icon">📊</div>
                <h3>Financial Planning</h3>
                <p>Tailored plans to meet your goals.</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="feature-icon">🔒</div>
                <h3>Secure Transactions</h3>
                <p>Your data is safe with us.</p>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-light py-5" id="testimonials">
        <div class="container">
            <h2 class="text-center">What Our Clients Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <blockquote class="blockquote text-center">
                        <p class="mb-0">"FinanceCo helped me achieve my financial goals!"</p>
                        <footer class="blockquote-footer">John Doe</footer>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <blockquote class="blockquote text-center">
                        <p class="mb-0">"Their investment strategies are top-notch!"</p>
                        <footer class="blockquote-footer">Jane Smith</footer>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <blockquote class="blockquote text-center">
                        <p class="mb-0">"I feel secure with their services!"</p>
                        <footer class="blockquote-footer">Emily Johnson</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container my-5" id="contact">
        <h2 class="text-center">Contact Us</h2>
        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-4">
        <div class="container">
            <p>&copy; 2023 FinanceCo. All rights reserved.</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#" class="text-dark">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#" class="text-dark">Terms of Service</a></li>
            </ul>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
