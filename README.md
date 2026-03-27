# Student Course Hub MVC

A custom PHP MVC web application built for the **CTEC2712 Web Application Development** group project.

The system is designed for a university to promote undergraduate and postgraduate degree programmes, allow prospective students to register interest in a programme, and enable administrators to manage programme data and mailing lists.

---

## Project Overview

**Student Course Hub** is a web application that helps prospective students:

- browse available programmes
- search and filter programmes
- view programme details
- see modules grouped by year
- view programme leaders and module leaders
- register their interest in a programme
- manage or withdraw that interest later

The application also includes an **administration area** for authorized users to manage programme content, modules, publishing status, and mailing lists.

---

## Assignment Context

This project was developed in response to the **Student Course Hub** scenario for the Web Application Development module.

The scenario required:

- a student-facing programme website
- an admin interface for content management
- mailing list support for interested students
- administrator authentication
- role-based access control
- secure handling of user input
- support for mobile-friendly and accessible use

This repository contains the implementation of those requirements using a custom PHP MVC structure.

---

## Main Features

### Student-facing features

- Public homepage for browsing available programmes
- Programme listing page
- Search programmes by keyword
- Filter programmes by level:
  - Undergraduate
  - Postgraduate
- View full programme details
- View modules linked to each programme
- Modules grouped by **year of study**
- View programme leader and module leader information
- Register interest in a programme using contact details
- Manage / withdraw interest using email-based workflow
- Only **published** programmes appear on the public side

### Administrator features

- Admin login and logout
- Role-based access control
- Admin dashboard
- Create, edit, and delete programmes
- Create, edit, and delete modules
- Assign modules to programmes
- Publish / unpublish programmes
- View interested student mailing lists
- Export mailing list data as **CSV**
- Separate admin roles for different levels of access

---

## Security Features

Because the system handles student contact details, security was treated as an important part of the implementation.

The project includes:

- Administrator authentication
- Role-based authorization
- Prepared statements for database queries
- CSRF protection for sensitive form actions
- Output escaping to reduce XSS risk
- Server-side validation and sanitization of user input

---

## Database Improvements

The provided starter SQL was extended to support additional project functionality.

Enhancements include:

- `AdminUsers` table for admin login
- Role support such as:
  - `super_admin`
  - `editor`
  - `mailer`
- `IsPublished` field for controlling public programme visibility
- support for active / withdrawn interest handling
- duplicate-interest prevention improvements
- accessibility-related image text support
- additional indexing and structure updates for smoother data access

These changes were made to better support the scenario requirements and improve usability of the system.

## Default admin logins
- `admin` / `Admin123!`
- `editor` / `Editor123!`
- `mailer` / `Mailer123!`

---

## MVC Structure

This project uses a custom MVC-style layout.

```text
app/
 ├── Controllers/   # Handles requests and application flow
 ├── Core/          # Core framework/bootstrap logic
 ├── Models/        # Database interaction
 └── Views/         # UI templates and pages

config/
 ├── config.php     # Database and app configuration
 └── routes.php     # Route definitions

public/
 └── assets/
     └── css/       # Stylesheets

sql/
 └── student_course_hub.sql

index.php           # Front controller
.htaccess           # Apache rewrite routing
README.md