<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Load content data
$contentFile = '../data/content.json';
$content = [];
if (file_exists($contentFile)) {
    $content = json_decode(file_get_contents($contentFile), true);
}

// Initialize default content structure if empty
if (empty($content)) {
    $content = [
        'homepage' => [
            'hero_title' => 'Discover the Red Sea\'s Hidden Treasures',
            'hero_subtitle' => 'Professional diving courses and unforgettable underwater adventures in Hurghada',
            'about_title' => 'Why Choose Pro Master Hurghada?',
            'about_text' => 'With over 10 years of experience in the Red Sea, we offer world-class diving education and guided tours.',
            'stats' => [
                'students' => '2000+',
                'years' => '10+',
                'sites' => '50+',
                'instructors' => '15+'
            ]
        ],
        'about' => [
            'page_title' => 'About Pro Master Hurghada',
            'page_subtitle' => 'Discover our story, meet our team, and learn about our commitment to exceptional diving experiences',
            'story_title' => 'Our Story',
            'story_text' => 'Founded in 2010, Pro Master Hurghada began as a dream to share the incredible underwater world of the Red Sea...',
            'mission_title' => 'Our Mission & Values',
            'mission_subtitle' => 'The principles that guide everything we do'
        ],
        'contact' => [
            'page_title' => 'Contact Us',
            'page_subtitle' => 'Get in touch with our team for bookings, questions, or diving advice',
            'address' => 'Hurghada Marina, Red Sea, Egypt',
            'phone' => '+20 123 456 7890',
            'email' => 'info@promasterhurghada.com',
            'hours' => 'Daily: 8:00 AM - 6:00 PM'
        ],
        'courses' => [
            'page_title' => 'PADI Diving Courses',
            'page_subtitle' => 'Professional diving education from beginner to instructor level',
            'featured_course' => [
                'title' => 'PADI Open Water Diver',
                'price' => '350',
                'description' => 'Start your diving adventure with the world\'s most popular scuba course.'
            ]
        ],
        'blog' => [
            'page_title' => 'Diving Blog',
            'page_subtitle' => 'Discover the latest diving tips, underwater adventures, and Red Sea marine life insights',
            'featured_post' => [
                'title' => 'The Ultimate Guide to Red Sea Diving',
                'excerpt' => 'Discover the most spectacular dive sites in the Red Sea, from vibrant coral reefs to historic shipwrecks.'
            ]
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard - Pro Master Hurghada</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0077BE;
            --secondary: #004d75;
            --accent: #FF6B6B;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --light: #F8FAFC;
            --dark: #1E293B;
            --gray: #64748B;
            --border: #E2E8F0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--border);
            padding: 2rem 0;
        }

        .logo {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .logo h2 {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: var(--gray);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--light);
            color: var(--primary);
            border-right: 3px solid var(--primary);
        }

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .header h1 {
            color: var(--dark);
            font-size: 2rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        /* Content Sections */
        .content-section {
            display: none;
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .content-section.active {
            display: block;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .form-grid {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--light);
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
        }

        .stat-card label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray);
        }

        .stat-card input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border);
            border-radius: 0.25rem;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
        }

        .alert.success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert.error {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .page-preview {
            background: var(--light);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 1px solid var(--border);
        }

        .preview-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                order: 2;
            }

            .main-content {
                order: 1;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <h2><i class="fas fa-fish"></i> Pro Master CMS</h2>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" data-section="homepage">
                            <i class="fas fa-home"></i>
                            Homepage
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="about">
                            <i class="fas fa-info-circle"></i>
                            About Page
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="courses">
                            <i class="fas fa-graduation-cap"></i>
                            Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="blog">
                            <i class="fas fa-blog"></i>
                            Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="contact">
                            <i class="fas fa-envelope"></i>
                            Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="pricing">
                            <i class="fas fa-dollar-sign"></i>
                            Pricing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="media">
                            <i class="fas fa-images"></i>
                            Media Library
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Content Management System</h1>
                <div class="user-menu">
                    <a href="../index.html" class="btn btn-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        View Website
                    </a>
                    <a href="logout.php" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </header>

            <div class="alert success" id="success-alert">
                <i class="fas fa-check-circle"></i>
                Content updated successfully!
            </div>

            <div class="alert error" id="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                Error updating content. Please try again.
            </div>

            <!-- Homepage Section -->
            <section class="content-section active" id="homepage-section">
                <h2 class="section-title">Homepage Content</h2>
                <form id="homepage-form" class="form-grid">
                    <div class="form-group">
                        <label for="hero_title">Hero Title</label>
                        <input type="text" id="hero_title" name="hero_title" value="<?php echo htmlspecialchars($content['homepage']['hero_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="hero_subtitle">Hero Subtitle</label>
                        <textarea id="hero_subtitle" name="hero_subtitle"><?php echo htmlspecialchars($content['homepage']['hero_subtitle'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="about_title">About Section Title</label>
                        <input type="text" id="about_title" name="about_title" value="<?php echo htmlspecialchars($content['homepage']['about_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="about_text">About Section Text</label>
                        <textarea id="about_text" name="about_text"><?php echo htmlspecialchars($content['homepage']['about_text'] ?? ''); ?></textarea>
                    </div>

                    <div class="stats-grid">
                        <div class="stat-card">
                            <label for="stat_students">Students Trained</label>
                            <input type="text" id="stat_students" name="stat_students" value="<?php echo htmlspecialchars($content['homepage']['stats']['students'] ?? ''); ?>">
                        </div>
                        <div class="stat-card">
                            <label for="stat_years">Years Experience</label>
                            <input type="text" id="stat_years" name="stat_years" value="<?php echo htmlspecialchars($content['homepage']['stats']['years'] ?? ''); ?>">
                        </div>
                        <div class="stat-card">
                            <label for="stat_sites">Dive Sites</label>
                            <input type="text" id="stat_sites" name="stat_sites" value="<?php echo htmlspecialchars($content['homepage']['stats']['sites'] ?? ''); ?>">
                        </div>
                        <div class="stat-card">
                            <label for="stat_instructors">Instructors</label>
                            <input type="text" id="stat_instructors" name="stat_instructors" value="<?php echo htmlspecialchars($content['homepage']['stats']['instructors'] ?? ''); ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save Homepage Content
                    </button>
                </form>
            </section>

            <!-- About Section -->
            <section class="content-section" id="about-section">
                <h2 class="section-title">About Page Content</h2>
                <form id="about-form" class="form-grid">
                    <div class="form-group">
                        <label for="about_page_title">Page Title</label>
                        <input type="text" id="about_page_title" name="page_title" value="<?php echo htmlspecialchars($content['about']['page_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="about_page_subtitle">Page Subtitle</label>
                        <textarea id="about_page_subtitle" name="page_subtitle"><?php echo htmlspecialchars($content['about']['page_subtitle'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="story_title">Story Section Title</label>
                        <input type="text" id="story_title" name="story_title" value="<?php echo htmlspecialchars($content['about']['story_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="story_text">Story Text</label>
                        <textarea id="story_text" name="story_text" rows="6"><?php echo htmlspecialchars($content['about']['story_text'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save About Content
                    </button>
                </form>
            </section>

            <!-- Contact Section -->
            <section class="content-section" id="contact-section">
                <h2 class="section-title">Contact Page Content</h2>
                <form id="contact-form" class="form-grid">
                    <div class="form-group">
                        <label for="contact_page_title">Page Title</label>
                        <input type="text" id="contact_page_title" name="page_title" value="<?php echo htmlspecialchars($content['contact']['page_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_page_subtitle">Page Subtitle</label>
                        <textarea id="contact_page_subtitle" name="page_subtitle"><?php echo htmlspecialchars($content['contact']['page_subtitle'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($content['contact']['address'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($content['contact']['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($content['contact']['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="hours">Business Hours</label>
                        <input type="text" id="hours" name="hours" value="<?php echo htmlspecialchars($content['contact']['hours'] ?? ''); ?>">
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save Contact Content
                    </button>
                </form>
            </section>

            <!-- Courses Section -->
            <section class="content-section" id="courses-section">
                <h2 class="section-title">Courses Page Content</h2>
                <form id="courses-form" class="form-grid">
                    <div class="form-group">
                        <label for="courses_page_title">Page Title</label>
                        <input type="text" id="courses_page_title" name="page_title" value="<?php echo htmlspecialchars($content['courses']['page_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="courses_page_subtitle">Page Subtitle</label>
                        <textarea id="courses_page_subtitle" name="page_subtitle"><?php echo htmlspecialchars($content['courses']['page_subtitle'] ?? ''); ?></textarea>
                    </div>
                    
                    <h3>Featured Course</h3>
                    <div class="form-group">
                        <label for="featured_course_title">Featured Course Title</label>
                        <input type="text" id="featured_course_title" name="featured_course_title" value="<?php echo htmlspecialchars($content['courses']['featured_course']['title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="featured_course_price">Featured Course Price (€)</label>
                        <input type="number" id="featured_course_price" name="featured_course_price" value="<?php echo htmlspecialchars($content['courses']['featured_course']['price'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="featured_course_description">Featured Course Description</label>
                        <textarea id="featured_course_description" name="featured_course_description"><?php echo htmlspecialchars($content['courses']['featured_course']['description'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save Courses Content
                    </button>
                </form>
            </section>

            <!-- Blog Section -->
            <section class="content-section" id="blog-section">
                <h2 class="section-title">Blog Page Content</h2>
                <form id="blog-form" class="form-grid">
                    <div class="form-group">
                        <label for="blog_page_title">Page Title</label>
                        <input type="text" id="blog_page_title" name="page_title" value="<?php echo htmlspecialchars($content['blog']['page_title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="blog_page_subtitle">Page Subtitle</label>
                        <textarea id="blog_page_subtitle" name="page_subtitle"><?php echo htmlspecialchars($content['blog']['page_subtitle'] ?? ''); ?></textarea>
                    </div>
                    
                    <h3>Featured Post</h3>
                    <div class="form-group">
                        <label for="featured_post_title">Featured Post Title</label>
                        <input type="text" id="featured_post_title" name="featured_post_title" value="<?php echo htmlspecialchars($content['blog']['featured_post']['title'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="featured_post_excerpt">Featured Post Excerpt</label>
                        <textarea id="featured_post_excerpt" name="featured_post_excerpt"><?php echo htmlspecialchars($content['blog']['featured_post']['excerpt'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Save Blog Content
                    </button>
                </form>
            </section>

            <!-- Pricing Section -->
            <section class="content-section" id="pricing-section">
                <h2 class="section-title">Pricing Management</h2>
                <div class="page-preview">
                    <div class="preview-title">Current Pricing Structure</div>
                    <p>Use this section to manage course prices, equipment rental rates, and special offers. Changes will be reflected on the price-list.html page.</p>
                    <br>
                    <a href="../price-list.html" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i>
                        View Current Price List
                    </a>
                </div>
            </section>

            <!-- Media Section -->
            <section class="content-section" id="media-section">
                <h2 class="section-title">Media Library</h2>
                <div class="page-preview">
                    <div class="preview-title">Image Management</div>
                    <p>Currently, the website uses high-quality stock images from Pexels and Unsplash. To maintain fast loading times and reduce hosting costs, we recommend continuing to use external image URLs.</p>
                    <br>
                    <p><strong>Current Image Sources:</strong></p>
                    <ul style="margin-left: 2rem; margin-top: 1rem;">
                        <li>Hero images: Unsplash diving photography</li>
                        <li>Course images: Pexels underwater shots</li>
                        <li>Blog images: High-quality marine life photos</li>
                    </ul>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Navigation functionality
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links and sections
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Show corresponding section
                const sectionId = this.dataset.section + '-section';
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Form submission functionality
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const section = this.id.replace('-form', '');
                
                // Add section identifier
                formData.append('section', section);
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.disabled = true;
                
                // Send data to update script
                fetch('update-content.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', 'Content updated successfully!');
                    } else {
                        showAlert('error', 'Error updating content: ' + data.message);
                    }
                })
                .catch(error => {
                    showAlert('error', 'Error updating content. Please try again.');
                })
                .finally(() => {
                    // Restore button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        });

        function showAlert(type, message) {
            const alert = document.getElementById(type + '-alert');
            alert.style.display = 'block';
            alert.querySelector('i').nextSibling.textContent = ' ' + message;
            
            // Hide after 5 seconds
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>