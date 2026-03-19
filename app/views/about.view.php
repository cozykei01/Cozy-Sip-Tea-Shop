<?php
$activePage = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Cozy Sip</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .about-hero {
            background: linear-gradient(rgba(0, 66, 37, 0.8), rgba(0, 66, 37, 0.8)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 5rem;
        }

        .about-hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
        }

        .about-hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
            animation: fadeInUp 1s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .story-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
            margin-bottom: 10rem;
        }

        .story-content h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            color: var(--cozy-dark);
            margin-bottom: 2rem;
            position: relative;
        }

        .story-content h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -0.5rem;
            width: 50px;
            height: 3px;
            background: var(--cozy-gold);
        }

        .story-content p {
            line-height: 1.8;
            color: #555;
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .story-image img {
            width: 100%;
            border-radius: 2rem;
            box-shadow: 20px 20px 0 var(--cozy-gold);
        }

        .values-section {
            background: var(--cozy-dark);
            padding: 8rem 0;
            margin: 5rem 0;
            color: white;
            border-radius: 3rem;
        }

        .values-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .values-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            color: var(--cozy-gold);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }

        .value-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 3rem;
            border-radius: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--cozy-gold);
        }

        .value-card i {
            font-size: 3rem;
            color: var(--cozy-gold);
            margin-bottom: 2rem;
        }

        .value-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .value-card p {
            color: #a0b2a6;
            line-height: 1.6;
        }

        .team-section {
            padding: 10rem 0;
            text-align: center;
        }

        .team-section h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            margin-bottom: 5rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .team-card {
            background: white;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
        }

        .team-img {
            height: 300px;
            overflow: hidden;
        }

        .team-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-info {
            padding: 2rem;
        }

        .team-info h3 {
            font-size: 1.25rem;
            color: var(--cozy-dark);
            margin-bottom: 0.5rem;
        }

        .team-info span {
            color: var(--cozy-green);
            font-weight: 600;
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .story-section { grid-template-columns: 1fr; gap: 3rem; }
            .values-grid { grid-template-columns: 1fr 1fr; }
            .team-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 576px) {
            .values-grid { grid-template-columns: 1fr; }
            .team-grid { grid-template-columns: 1fr; }
            .about-hero h1 { font-size: 3rem; }
        }
    </style>
</head>
<body>
    <?php include 'partials/navbar.php'; ?>

    <section class="about-hero">
        <div class="container">
            <h1>Brewing Joy Since 2024</h1>
            <p>From a small cart on the corner to a community hub for coffee lovers. Our journey is about more than just beans.</p>
        </div>
    </section>

    <div class="container">
        <section class="story-section">
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?auto=format&fit=crop&q=80&w=800" alt="Our Coffee Story">
            </div>
            <div class="story-content">
                <h2>Our Story</h2>
                <p>Cozy Sip started with a simple belief: that a great cup of coffee has the power to brighten anyone's day. What began in a small corner shop has grown into a destination for those who appreciate the art of slow brewing and the comfort of community.</p>
                <p>We source our beans directly from sustainable farms across Myanmar and beyond, ensuring that every sip you take supports both the environment and the dedicated farmers who make it possible.</p>
                <p>Our goal is to create a space where time slows down, conversations flow, and every visitor feels at home. Welcome to our cozy corner of the world.</p>
            </div>
        </section>
    </div>

    <section class="values-section">
        <div class="container">
            <div class="values-header">
                <h2>Our Core Values</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <i class="fa-solid fa-leaf"></i>
                    <h3>Sustainability</h3>
                    <p>We are committed to eco-friendly practices, from compostable cups to direct-trade sourcing.</p>
                </div>
                <div class="value-card">
                    <i class="fa-solid fa-heart"></i>
                    <h3>Community</h3>
                    <p>Cozy Sip is a home for everyone. We believe in fostering local connections and kindness.</p>
                </div>
                <div class="value-card">
                    <i class="fa-solid fa-award"></i>
                    <h3>Quality</h3>
                    <p>No compromises. We meticulously test every roast to ensure perfection in every single drop.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <section class="team-section">
            <h2>Meet Our Experts</h2>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-img">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=400" alt="Sarah Rose">
                    </div>
                    <div class="team-info">
                        <h3>Sarah Rose</h3>
                        <span>Founding Barista</span>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-img">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=400" alt="Michael Chen">
                    </div>
                    <div class="team-info">
                        <h3>Michael Chen</h3>
                        <span>Head Roaster</span>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-img">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=400" alt="Elena Sofia">
                    </div>
                    <div class="team-info">
                        <h3>Elena Sofia</h3>
                        <span>Pastry Chef</span>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-img">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=400" alt="David Kyaw">
                    </div>
                    <div class="team-info">
                        <h3>David Kyaw</h3>
                        <span>Quality Controller</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script>
    // Toast Notification Function
    function showToast(message, icon = 'fa-check-circle') {
        const toast = document.createElement('div');
        toast.style = "position: fixed; bottom: 100px; right: 20px; background: #004225; color: white; padding: 1rem 2rem; border-radius: 2rem; z-index: 10000; animation: fadeInUp 0.5s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;";
        toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${message}`;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            toast.style.transition = 'all 0.5s ease';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
    </script>
</body>
</html>
