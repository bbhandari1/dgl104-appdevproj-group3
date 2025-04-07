# Task Management System (TMS) - User Guide

## Introduction
The Task Management System (TMS) is a web-based tool that helps you manage tasks and leave requests within your organization. This guide explains how to log in, perform key actions, and navigate the system based on your role: Admin, Team Lead, or User.

---

## 1. Getting Started

### 1.1 Accessing the System
- Open your web browser and go to `http://localhost/index.php` (or the URL provided by your administrator).
- You’ll see the home page with login options for Admin and User/Team Lead.

### 1.2 Logging In
- **Admin Login**:
  - Select "Admin Login" from the home page.
  - Enter your credentials (e.g., Email: `admin@gmail.com`, Password: `admin@123`).
- **User/Team Lead Login**:
  - Select "User/Team Lead Login" from the home page.
  - Enter your email and password (e.g., Email: `test@gmail.com`, Password: `test@123` for a Team Lead).

If your credentials are incorrect, you’ll see an error message. Contact your administrator if you need assistance.

---

## 2. Role-Specific Instructions

### 2.1 Admin
**Dashboard**: After logging in, you’ll see options to manage users and tasks.
- **Create a Task**:
  1. Fill out the "Create New Task" form with:
     - User ID (e.g., `1` for a specific user).
     - Description (e.g., "Prepare meeting slides").
     - Start Date and End Date.
     - Priority (Normal or Urgent).
  2. Click "Create Task". You’ll see a confirmation message.
- **View Tasks**: Check the task list below the form to see all tasks assigned to users.

**Logout**: Click "Logout" to end your session.

### 2.2 Team Lead
**Dashboard**: After logging in, you’ll see a sidebar on the left and a main content area on the right.
- **Create a Task**:
  1. Click "Create Task" in the sidebar.
  2. Fill out the form (loaded dynamically) with task details and assignee ID.
  3. Submit to assign the task.
- **View Team Tasks**:
  1. Click "Team Tasks" to see all tasks you’ve created.
  2. Review task details like priority, assignee, and status.
- **View Assigned Tasks**:
  1. Click "My Assigned Tasks" to see tasks assigned to you.
  2. Update status if needed (see "Update Task Status" below).
- **Apply for Leave**:
  1. Click "Apply Leave".
  2. Enter a subject (e.g., "Sick Leave") and message.
  3. Submit the form. You’ll get a confirmation.
- **Check Leave Status**:
  1. Click "Leave Status" to see your leave requests and their statuses (e.g., No Action, Approved, Rejected).

**Logout**: Click "Logout" in the sidebar.

### 2.3 User
**Dashboard**: After logging in, you’ll see a sidebar with options and a welcome message.
- **Update Task Status**:
  1. Click "Update Task" to view your assigned tasks.
  2. Find the task in the list and click "Update".
  3. Select a new status (Complete or In-Progress) and submit.
- **Apply for Leave**:
  1. Click "Apply Leave".
  2. Enter a subject and message, then submit.
- **Check Leave Status**:
  1. Click "Leave Status" to view your leave requests.

**Logout**: Click "Logout" in the sidebar.

---

## 3. Key Features

### 3.1 Task Management
- **Priorities**: Tasks marked "Urgent" appear with a red background.
- **Statuses**: Options include "Not Started", "In Progress", and "Complete".
- **Sorting**: Tasks are sorted by priority and date for easy tracking.

### 3.2 Leave Management
- Submit leave requests with a subject and message.
- Track statuses: "No Action" (pending), "Approved", or "Rejected".

### 3.3 Navigation
- Use the sidebar to switch between features without reloading the page.
- Click "Dashboard" to return to the main view.