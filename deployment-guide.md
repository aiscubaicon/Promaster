# Pro Master Hurghada - Deployment Guide

## Files to Upload to Hostilica Shared Hosting

### Required Files
Upload all these files to your `public_html` directory:

#### Main Pages
- `index.html` - Homepage
- `about.html` - About page
- `blog.html` - Blog listing
- `contact.html` - Contact page (updated with PHP form handler)
- `courses.html` - Courses page
- `daily-trips.html` - Daily trips page
- `price-list.html` - Price list page
- `shopping-cart.html` - Shopping cart page

#### Blog Posts
- `blog-post-red-sea-guide.html`
- `blog-post-safety-tips.html`
- `blog-post-sharks.html`
- `blog-post-brothers-islands.html`
- `blog-post-equipment-guide.html`
- `blog-post-photography.html`
- `blog-post-coral-reefs.html`
- `blog-post-thistlegorm.html`
- `blog-post-buoyancy-control.html`
- `blog-post-certification-journey.html`

#### Trip Details
- `trip-giftun-island.html`
- `trip-abu-nuhas.html`

#### Backend & Configuration
- `contact-handler.php` - PHP script for contact form
- `.htaccess` - Server configuration
- `robots.txt` - Search engine instructions

#### Error Pages
- `404.html` - Page not found
- `500.html` - Server error

#### Documentation
- `deployment-guide.md` - This file (optional)

## Configuration Steps

### 1. Email Configuration
Edit `contact-handler.php` and update these lines:
```php
$to_email = 'info@promasterhurghada.com'; // Your actual email
$from_email = 'noreply@yourdomain.com'; // Your domain email
```

### 2. Domain Configuration
Update `robots.txt` with your actual domain:
```
Sitemap: https://yourdomain.com/sitemap.xml
```

### 3. SSL Certificate (Optional)
If you have an SSL certificate, uncomment these lines in `.htaccess`:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## Features Included

### Contact Form
- Secure PHP handler with validation
- Email notifications to your inbox
- AJAX submission with user feedback
- Spam protection and input sanitization
- Contact log file (protected from public access)

### SEO & Performance
- Clean URLs (removes .html extension)
- File compression (gzip)
- Browser caching
- Security headers
- Custom error pages

### Security
- Input sanitization
- Protected sensitive files
- XSS protection headers
- Clickjacking prevention

## Testing Checklist

After uploading:
1. ✅ Test homepage loads correctly
2. ✅ Test all navigation links work
3. ✅ Test contact form submission
4. ✅ Check email delivery
5. ✅ Test shopping cart functionality
6. ✅ Verify all blog posts load
7. ✅ Test responsive design on mobile
8. ✅ Check 404 error page
9. ✅ Verify SSL certificate (if installed)

## Troubleshooting

### Contact Form Not Working
- Check PHP is enabled on your hosting
- Verify email settings in `contact-handler.php`
- Check server error logs
- Ensure proper file permissions (644 for PHP files)

### Images Not Loading
- All images use external URLs (Pexels/Unsplash)
- No local image files needed
- Check internet connection if images don't load

### Performance Issues
- `.htaccess` includes compression and caching
- All CSS/JS is embedded (no external files)
- Optimize if needed based on hosting performance

## Support
For technical support with deployment, contact your Hostilica hosting support team.

## Notes
- Website is fully static except for contact form
- No database required
- Shopping cart uses browser localStorage
- All functionality works on shared hosting
- Mobile responsive design included