# Pro Master Hurghada CMS - User Guide

## Overview
This Content Management System (CMS) allows you to easily edit and update all content on your Pro Master Hurghada website without needing technical knowledge.

## Getting Started

### Login Credentials
- **URL**: `yourdomain.com/admin/`
- **Username**: `admin`
- **Password**: `promaster2024`

**IMPORTANT**: Change the default password in `admin/login.php` before going live!

## Features

### 1. Homepage Management
- **Hero Section**: Update main title and subtitle
- **About Section**: Edit about text and title
- **Statistics**: Update numbers for students, years, sites, instructors
- **Real-time Preview**: See changes immediately

### 2. About Page Management
- **Page Header**: Edit title and subtitle
- **Story Section**: Update company story and mission
- **Team Information**: Manage team member details

### 3. Contact Information
- **Contact Details**: Update address, phone, email
- **Business Hours**: Modify operating hours
- **Emergency Contact**: Update emergency numbers

### 4. Courses Management
- **Page Content**: Edit course descriptions
- **Featured Course**: Highlight specific courses
- **Pricing**: Update course prices

### 5. Blog Management
- **Page Header**: Edit blog title and description
- **Featured Posts**: Manage highlighted articles
- **Categories**: Organize blog content

### 6. Pricing Management
- **Course Prices**: Update all course pricing
- **Equipment Rental**: Manage rental rates
- **Special Offers**: Create and edit promotions

## How to Use

### Making Changes
1. **Login** to the admin panel
2. **Select** the page you want to edit from the sidebar
3. **Update** the content in the form fields
4. **Click Save** to apply changes
5. **View Website** to see your changes live

### Content Guidelines
- **Keep titles concise** and descriptive
- **Use clear language** that your customers understand
- **Update regularly** to keep content fresh
- **Check spelling** before saving

### Best Practices
- **Backup regularly**: The system creates automatic backups
- **Test changes**: Always preview before publishing
- **Mobile-friendly**: Keep text readable on mobile devices
- **SEO-friendly**: Use relevant keywords naturally

## Security

### Password Security
- Change default password immediately
- Use strong passwords (12+ characters)
- Don't share login credentials
- Log out when finished

### File Protection
- Admin area is password protected
- Data files are secured from public access
- Automatic backups are created

## Troubleshooting

### Common Issues
1. **Can't login**: Check username/password
2. **Changes not showing**: Clear browser cache
3. **Form not saving**: Check internet connection
4. **Images not loading**: Verify image URLs

### Getting Help
- Check this guide first
- Contact your web developer
- Keep backup files safe

## Technical Notes

### File Structure
```
admin/
├── index.php          # Main dashboard
├── login.php          # Login page
├── logout.php         # Logout handler
├── update-content.php # Content updater
└── .htaccess          # Security settings

data/
├── content.json       # Main content file
└── backups/          # Automatic backups
```

### Backup System
- Automatic backups created on each save
- Stored in `data/` directory
- Named with timestamp
- Keep recent backups safe

### Content Storage
- All content stored in JSON format
- Easy to backup and restore
- Version controlled
- Secure from public access

## Maintenance

### Regular Tasks
- **Weekly**: Review and update content
- **Monthly**: Check for broken links
- **Quarterly**: Update contact information
- **Annually**: Review all pricing

### Updates
- Keep login credentials secure
- Monitor website performance
- Update content regularly
- Backup important changes

## Support
For technical support or questions about using the CMS, contact your web developer or hosting provider.

---

**Pro Master Hurghada CMS v1.0**
*Professional Content Management for Diving Centers*