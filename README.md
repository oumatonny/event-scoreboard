# Event Scoreboard - LAMP Stack Implementation

By Tonny Ouma

[oumatonny8@gmail.com](mailto:oumatonny8@gmail.com "oumatonny8@gmail.com")

[oumatonny.github.io](oumatonny.github.io "oumatonny.github.io") 

A professional event scoreboard system built with PHP, MySQL, HTML, CSS, and JavaScript.


Live [oumatonny-event-scoreboard.42web.io ](oumatonny-event-scoreboard.42web.io "oumatonny-event-scoreboard.42web.io")

## Features

- Admin panel for judge management
- Judge portal for scoring participants
- Public scoreboard with auto-refresh
- Professional green, red, and black color scheme
- Kenyan-themed participant names

## Setup Instructions

1. **Prerequisites**:

   - Apache web server
   - MySQL database
   - PHP 7.0 or higher
2. **Database Setup**:

   - Create a database named `event_scoreboard`
   - Import the SQL schema from `event_scoreboard.sql`
3. **Configuration**:

   - Update database credentials in `includes/config.php`
4. **Directory Structure**:

   - Place all files in your web server's document root
   - Ensure proper permissions for Apache to write to the directory

## Design Choices

- **Database Schema**: Used three main tables (judges, users, scores) with proper relationships
- **PHP**: Used PDO for database access with prepared statements for security
- **Frontend**: Responsive design with clean, professional styling
- **Auto-refresh**: Implemented with JavaScript fetch API for dynamic updates

## Assumptions

- Judges and Admins are Authorized as one
- Judges are pre-assigned to score participants
- Participants are pre-registered in the system

## Future Enhancements

1. Adding proper user authentication
2. Implementing event management
3. Adding judge assignment to specific participants
4. Including more detailed scoring criteria
5. Adding export functionality for results
6. Implementing real-time updates with WebSockets
