<?php
$activePage = 'contact';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cozy Sip</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .contact-hero {
            background: linear-gradient(rgba(0, 66, 37, 0.8), rgba(0, 66, 37, 0.8)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            height: 40vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 5rem;
        }

        .contact-hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 3.5rem;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 4rem;
            margin-bottom: 8rem;
        }

        .contact-info-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            padding: 2rem;
            border-radius: 1.5rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: var(--cozy-gold);
        }

        .info-card i {
            font-size: 1.5rem;
            color: white;
            background: var(--cozy-green);
            width: 3.5rem;
            height: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            flex-shrink: 0;
        }

        .info-card h3 {
            font-size: 1.2rem;
            color: var(--cozy-dark);
            margin-bottom: 0.5rem;
        }

        .info-card p {
            color: #666;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .contact-form-container {
            background: white;
            padding: 3.5rem;
            border-radius: 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid #f0f0f0;
        }

        .contact-form-container h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            color: var(--cozy-dark);
            margin-bottom: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--cozy-dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 1px solid #e0e0e0;
            border-radius: 1rem;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fbf9;
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: var(--cozy-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(0, 66, 37, 0.05);
        }

        .submit-btn {
            background: var(--cozy-green);
            color: white;
            border: none;
            padding: 1.2rem 2.5rem;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background: var(--cozy-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 66, 37, 0.2);
        }

        .map-section {
            height: 500px;
            border-radius: 2.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            margin-bottom: 5rem;
            border: 8px solid white;
        }

        .map-section iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        @media (max-width: 992px) {
            .contact-grid { grid-template-columns: 1fr; }
            .contact-form-container { padding: 2.5rem; }
        }
    </style>
</head>
<body>
    <?php include 'partials/navbar.php'; ?>

    <section class="contact-hero">
        <div class="container">
            <h1>Get In Touch</h1>
            <p>We'd love to hear from you. Send us a message and we'll get back to you shortly.</p>
        </div>
    </section>

    <div class="container">
        <div class="contact-grid">
            <div class="contact-info-cards">
                <div class="info-card">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <h3>Our Location</h3>
                        <p>123 Coffee Lane, Golden Valley<br>Bahan Township, Yangon, Myanmar</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <h3>Phone Number</h3>
                        <p>+95 9 123 456 789<br>+95 1 555 777</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <h3>Email Address</h3>
                        <p>hello@cozysip.com<br>support@cozysip.com</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fa-solid fa-clock"></i>
                    <div>
                        <h3>Working Hours</h3>
                        <p>Mon - Fri: 7:00 AM - 9:00 PM<br>Sat - Sun: 8:00 AM - 10:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <h2>Send Us a Message</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" placeholder="How can we help?" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="submit-btn" id="submitBtn">Send Message</button>
                </form>
            </div>
        </div>

        <div class="map-section">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m12!1m3!1d3819.336154388657!2d96.15570207570577!3d16.809695619176437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1ecbc29606821%3A0xe54911d33198083a!2sShwedagon%20Pagoda!5e0!3m2!1sen!2smm!4v1710849000000!5m2!1sen!2smm" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
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

    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const originalText = btn.innerText;
        
        btn.innerText = 'Sending...';
        btn.disabled = true;
        
        // Simulate sending
        setTimeout(() => {
            if (typeof showToast === 'function') {
                showToast('Message sent successfully! We will contact you soon.', 'fa-paper-plane');
            } else {
                alert('Message sent successfully!');
            }
            btn.innerText = originalText;
            btn.disabled = false;
            e.target.reset();
        }, 1500);
    });
    </script>
</body>
</html>
