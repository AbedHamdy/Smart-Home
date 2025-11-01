# Database Schema Documentation

## Overview
The Smart Home system uses MySQL as its primary database. Below is a detailed description of the database schema and relationships.

## Tables

### users
Stores user information for both homeowners and technicians.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(255) | User's full name |
| email | varchar(255) | Unique email address |
| password | varchar(255) | Hashed password |
| role | enum | 'homeowner', 'technician', 'admin' |
| phone | varchar(20) | Contact number |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### devices
Stores information about smart home devices.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users |
| name | varchar(255) | Device name |
| type | varchar(50) | Device type (light, thermostat, etc.) |
| model | varchar(100) | Device model number |
| room | varchar(50) | Location in house |
| status | enum | 'online', 'offline', 'maintenance' |
| last_reading | timestamp | Last status update |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### technician_profiles
Additional information for technician users.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users |
| experience_years | int | Years of experience |
| skills | text | List of skills |
| certifications | text | Professional certifications |
| rating | decimal(3,2) | Average rating |
| total_reviews | int | Number of reviews |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### appointments
Service appointments between homeowners and technicians.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| homeowner_id | bigint | Foreign key to users |
| technician_id | bigint | Foreign key to users |
| service_type | varchar(50) | Type of service |
| description | text | Service description |
| status | enum | 'pending', 'confirmed', 'completed', 'cancelled' |
| scheduled_for | datetime | Appointment time |
| completed_at | datetime | Completion time |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### device_readings
Historical data from device sensors.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| device_id | bigint | Foreign key to devices |
| reading_type | varchar(50) | Type of reading |
| value | decimal(10,2) | Reading value |
| unit | varchar(20) | Measurement unit |
| timestamp | timestamp | Reading time |

### categories
Device and service categories.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(100) | Category name |
| description | text | Category description |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### reviews
User reviews for technicians.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| appointment_id | bigint | Foreign key to appointments |
| rating | int | Rating (1-5) |
| comment | text | Review comment |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

## Relationships

### One-to-Many
- users → devices (A user can have many devices)
- users → technician_profiles (A user can have one technician profile)
- technicians → appointments (A technician can have many appointments)
- homeowners → appointments (A homeowner can have many appointments)
- devices → device_readings (A device can have many readings)
- appointments → reviews (An appointment can have one review)

### Many-to-Many
- technicians ↔ categories (through technician_categories)
- devices ↔ categories (through device_categories)

## Indexes
- users.email (unique)
- devices.user_id
- appointments.homeowner_id
- appointments.technician_id
- device_readings.device_id
- reviews.appointment_id

## Constraints
- ON DELETE CASCADE for device_readings when a device is deleted
- ON DELETE RESTRICT for appointments (prevent deletion of users with active appointments)
- CHECK constraints on reviews.rating (1-5)
- NOT NULL constraints on essential fields
