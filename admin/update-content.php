<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$section = $_POST['section'] ?? '';
$contentFile = '../data/content.json';
$backupFile = '../data/content_backup_' . date('Y-m-d_H-i-s') . '.json';

// Create data directory if it doesn't exist
if (!file_exists('../data')) {
    mkdir('../data', 0755, true);
}

// Load existing content
$content = [];
if (file_exists($contentFile)) {
    $content = json_decode(file_get_contents($contentFile), true);
    // Create backup
    copy($contentFile, $backupFile);
}

try {
    switch ($section) {
        case 'homepage':
            $content['homepage'] = [
                'hero_title' => $_POST['hero_title'] ?? '',
                'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
                'about_title' => $_POST['about_title'] ?? '',
                'about_text' => $_POST['about_text'] ?? '',
                'stats' => [
                    'students' => $_POST['stat_students'] ?? '',
                    'years' => $_POST['stat_years'] ?? '',
                    'sites' => $_POST['stat_sites'] ?? '',
                    'instructors' => $_POST['stat_instructors'] ?? ''
                ]
            ];
            break;

        case 'about':
            $content['about'] = [
                'page_title' => $_POST['page_title'] ?? '',
                'page_subtitle' => $_POST['page_subtitle'] ?? '',
                'story_title' => $_POST['story_title'] ?? '',
                'story_text' => $_POST['story_text'] ?? ''
            ];
            break;

        case 'contact':
            $content['contact'] = [
                'page_title' => $_POST['page_title'] ?? '',
                'page_subtitle' => $_POST['page_subtitle'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'hours' => $_POST['hours'] ?? ''
            ];
            break;

        case 'courses':
            $content['courses'] = [
                'page_title' => $_POST['page_title'] ?? '',
                'page_subtitle' => $_POST['page_subtitle'] ?? '',
                'featured_course' => [
                    'title' => $_POST['featured_course_title'] ?? '',
                    'price' => $_POST['featured_course_price'] ?? '',
                    'description' => $_POST['featured_course_description'] ?? ''
                ]
            ];
            break;

        case 'blog':
            $content['blog'] = [
                'page_title' => $_POST['page_title'] ?? '',
                'page_subtitle' => $_POST['page_subtitle'] ?? '',
                'featured_post' => [
                    'title' => $_POST['featured_post_title'] ?? '',
                    'excerpt' => $_POST['featured_post_excerpt'] ?? ''
                ]
            ];
            break;

        default:
            throw new Exception('Invalid section');
    }

    // Save updated content
    if (file_put_contents($contentFile, json_encode($content, JSON_PRETTY_PRINT))) {
        // Update the actual HTML files
        updateHtmlFiles($content, $section);
        
        echo json_encode(['success' => true, 'message' => 'Content updated successfully']);
    } else {
        throw new Exception('Failed to save content file');
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function updateHtmlFiles($content, $section) {
    switch ($section) {
        case 'homepage':
            updateHomepage($content['homepage']);
            break;
        case 'about':
            updateAboutPage($content['about']);
            break;
        case 'contact':
            updateContactPage($content['contact']);
            break;
        case 'courses':
            updateCoursesPage($content['courses']);
            break;
        case 'blog':
            updateBlogPage($content['blog']);
            break;
    }
}

function updateHomepage($data) {
    $file = '../index.html';
    if (!file_exists($file)) return;
    
    $html = file_get_contents($file);
    
    // Update hero section
    $html = preg_replace(
        '/<h1 class="hero-title"[^>]*>.*?<\/h1>/s',
        '<h1 class="hero-title">' . htmlspecialchars($data['hero_title']) . '</h1>',
        $html
    );
    
    $html = preg_replace(
        '/<p class="hero-subtitle"[^>]*>.*?<\/p>/s',
        '<p class="hero-subtitle">' . htmlspecialchars($data['hero_subtitle']) . '</p>',
        $html
    );
    
    // Update stats
    $html = preg_replace(
        '/<span class="stat-number" data-target="\d+">\d+\+<\/span>/',
        '<span class="stat-number" data-target="' . preg_replace('/[^0-9]/', '', $data['stats']['students']) . '">' . htmlspecialchars($data['stats']['students']) . '</span>',
        $html,
        1
    );
    
    file_put_contents($file, $html);
}

function updateAboutPage($data) {
    $file = '../about.html';
    if (!file_exists($file)) return;
    
    $html = file_get_contents($file);
    
    // Update page header
    $html = preg_replace(
        '/<h1>.*?<\/h1>/s',
        '<h1>' . htmlspecialchars($data['page_title']) . '</h1>',
        $html,
        1
    );
    
    $html = preg_replace(
        '/<p>.*?<\/p>/s',
        '<p>' . htmlspecialchars($data['page_subtitle']) . '</p>',
        $html,
        1
    );
    
    file_put_contents($file, $html);
}

function updateContactPage($data) {
    $file = '../contact.html';
    if (!file_exists($file)) return;
    
    $html = file_get_contents($file);
    
    // Update contact information
    $html = preg_replace(
        '/\+20 123 456 7890/',
        htmlspecialchars($data['phone']),
        $html
    );
    
    $html = preg_replace(
        '/info@promasterhurghada\.com/',
        htmlspecialchars($data['email']),
        $html
    );
    
    file_put_contents($file, $html);
}

function updateCoursesPage($data) {
    $file = '../courses.html';
    if (!file_exists($file)) return;
    
    $html = file_get_contents($file);
    
    // Update featured course
    $html = preg_replace(
        '/<h1>.*?<\/h1>/s',
        '<h1>' . htmlspecialchars($data['page_title']) . '</h1>',
        $html,
        1
    );
    
    file_put_contents($file, $html);
}

function updateBlogPage($data) {
    $file = '../blog.html';
    if (!file_exists($file)) return;
    
    $html = file_get_contents($file);
    
    // Update page title
    $html = preg_replace(
        '/<h1>.*?<\/h1>/s',
        '<h1>' . htmlspecialchars($data['page_title']) . '</h1>',
        $html,
        1
    );
    
    file_put_contents($file, $html);
}
?>