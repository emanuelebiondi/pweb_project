# Project Overview

### Welcome to My App!

This project integrates modern design and user-friendly features to streamline user interactions. Below are some key details about the project.

---

## 🎨 Color Palette

![#F4F1DE](https://placehold.co/15x15/F4F1DE/F4F1DE.png) `#F4F1DE` - Soft Cream  
![#E07A5F](https://placehold.co/15x15/E07A5F/E07A5F.png) `#E07A5F` - Coral Red  
![#3D405B](https://placehold.co/15x15/3D405B/3D405B.png) `#3D405B` - Slate Gray  
![#81B29A](https://placehold.co/15x15/81B29A/81B29A.png) `#81B29A` - Sage Green  
![#F2CC8F](https://placehold.co/15x15/F2CC8F/F2CC8F.png) `#F2CC8F` - Sand  
![#1F5270](https://placehold.co/15x15/1F5270/1F5270.png) `#1F5270` - Ocean Blue

[Explore this palette on Coolors](https://coolors.co/f4f1de-e07a5f-3d405b-81b29a-f2cc8f)

---

## 👥 User Data

Here is a preview of sample users in the system, along with their associated details:

| **Name**  | **Surname** | **Email**                    | **Password** | **House ID** | **House Name**      | **Join Code** |
| --------- | ----------- | ---------------------------- | ------------ | ------------ | ------------------- | ------------- |
| Gianluca  | Berni       | gianluca.berni@gmail.com     | Password!123 | 67           | House of Gabriela   | ac1611        |
| Luca      | Rovazzi     | luca.rovazzi@gmail.com       | Password!123 | 67           | House of Gabriela   | ac1611        |
| Franco    | De Lucia    | franco.de.lucia@gmail.com    | Password!123 | 68           | Via Roma 19         | d21464        |
| Giuseppe  | Francini    | giuseppino190@gmail.com      | Password!123 | 68           | Via Roma 19         | d21464        |
| Emanuele  | Biondi      | emanuelebiondi@cohabitat.it  | Password!123 | 67           | House of Gabriela   | ac1611        |
| Filippo   | Rossi       | filippo.rossi@gmail.com      | Password!123 | NULL         | NULL                | NULL          |
| Francesco | Beltrani    | francesco_beltrani@gmail.com | Password!123 | 71           | I ragazzi di Via Po | 4598d8        |
| Carola    | Bellini     | carola.bellini@icloud.it     | Password!123 | 71           | I ragazzi di Via Po | 4598d8        |
| Marco     | Ruta        | marco.ruta@gmail.com         | Password!123 | 68           | Via Roma 19         | d21464        |

## 🔑 Key Details

- **House ID**: Identifies the associated residence. `NULL` indicates no association.
- **Passwords**: For demo purposes only. In a real-world application, always encrypt passwords.

---

# Application Overview

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Architecture**: RESTful API with middleware authentication control

---

## 🚀 Features

- User authentication and registration
- Expense and payment tracking
- SettleUp
- Password management
- House management
- Categorization of expenses
- House Reminders Board

---

## 📚 API Endpoints

### Authentication Endpoints

| **Endpoint**      | **Method** | **Description**      |
| ----------------- | ---------- | -------------------- |
| `/register`       | `POST`     | Register a new user  |
| `/login`          | `POST`     | User login           |
| `/passwordChange` | `POST`     | Change user password |

### User Management

| **Endpoint** | **Method** | **Description**                       |
| ------------ | ---------- | ------------------------------------- |
| `/user`      | `GET`      | Retrieve all users details of a house |
| `/user/{id}` | `GET `     | Retrieve user details                 |
| `/user`      | `PUT`      | Update user details                   |

### Expense Management

| **Endpoint**               | **Method** | **Description**                                     |
| -------------------------- | ---------- | --------------------------------------------------- |
| `/expense/all?page={page}` | `GET`      | List expenses of user's house                       |
| `/expense/statistics`      | `GET`      | List expenses of user's house with W,M,Y statistics |
| `/expense/{id}`            | `GET`      | Get expense info                                    |
| `/expense`                 | `POST`     | Create a new expense                                |
| `/expense`                 | `PUT`      | Update an expense                                   |
| `/expense/{id}`            | `DELETE`   | Delete an expense                                   |

### Payment Management

| **Endpoint**               | **Method** | **Description**        |
| -------------------------- | ---------- | ---------------------- |
| `/payment/all?page={page}` | `GET`      | Retrieve payments      |
| `/payment/settleup`        | `GET`      | Retrieve settleup info |
| `/payment`                 | `POST`     | Record a new payment   |
| `/payment`                 | `PUT`      | Update payment details |
| `/payment/{id}`            | `DELETE`   | Delete a payment       |

### House Management

| **Endpoint**                   | **Method** | **Description**               |
| ------------------------------ | ---------- | ----------------------------- |
| `/house/join_code/{join_code}` | `GET`      | Get house info by join_code   |
| `/house/findjoincode`          | `GET`      | Get join_code of user's house |
| `/house/{id}`                  | `GET`      | Get house info                |
| `/house`                       | `POST`     | Add a new house               |

### Category Management

| **Endpoint**     | **Method** | **Description**       |
| ---------------- | ---------- | --------------------- |
| `/category`      | `GET`      | Retrieve categories   |
| `/category`      | `POST`     | Create a new category |
| `/category`      | `PUT`      | Update a category     |
| `/category/{id}` | `DELETE`   | Delete a category     |

### Reminder Management

| **Endpoint**     | **Method** | **Description**       |
| ---------------- | ---------- | --------------------- |
| `/reminder`      | `GET`      | List reminders        |
| `/reminder`      | `POST`     | Create a new reminder |
| `/reminder`      | `PUT`      | Update a reminder     |
| `/reminder/{id}` | `DELETE`   | Delete a reminder     |

---

## 🔒 Authentication Middleware

The application uses a middleware layer to ensure all requests to protected endpoints are authenticated. Unauthorized requests return a `401 Unauthorized` response.

---

## 🛡️ Error Handling

- **404 Not Found**: If the endpoint does not exist or the resource is not found.
- **500 Internal Server Error**: For unexpected errors.

---

## 💻 Getting Started

1. Clone the repository.
2. Configure your environment and database connection.
3. Start the Apache Server
4. Start the MySql Server
