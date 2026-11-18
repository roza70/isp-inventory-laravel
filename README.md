# Smart Corporate Cafeteria, Catering & Kitchen Management System

A web-based cafeteria and kitchen management system designed to manage daily employee meals, kitchen operations, inventory, procurement, supplier payments, catering services, food waste, and management reporting.

## Project Overview

The **Smart Corporate Cafeteria, Catering & Kitchen Management System** aims to digitize and simplify the operations of a corporate cafeteria.

The organization provides free daily lunch to its employees through a self-service system. Employees collect meals using their Employee ID or QR code, while cafeteria administrators and staff manage menus, meal demand, recipes, kitchen preparation, inventory, procurement, and other operational activities.

The system will also support special events, catering services, supplier payments, food waste tracking, analytics, and management insights.

## Project Objectives

- Digitize daily cafeteria operations.
- Manage free employee lunch collection.
- Prevent duplicate meal collection.
- Estimate daily meal demand.
- Simplify kitchen and recipe management.
- Track ingredients and inventory.
- Monitor product expiry using FEFO.
- Manage suppliers and grocery procurement.
- Track full and partial supplier payments.
- Manage special events and catering operations.
- Monitor food waste and operational expenses.
- Generate useful reports and management insights.

## Technology Stack

| Technology | Purpose |
|---|---|
| C# | Backend programming language |
| .NET 10 | Application framework |
| ASP.NET Core MVC | Web application architecture |
| SQL Server | Database |
| Entity Framework Core | Database access and ORM (planned) |
| HTML5 | Frontend structure |
| CSS3 | Frontend styling |
| Bootstrap | Responsive UI |
| JavaScript | Frontend interactions |
| Visual Studio | Development environment |
| Git & GitHub | Version control |

## Main Modules and Features

The project consists of 23 planned modules.

### 1. Authentication & User Management
- Login and logout
- Role management
- Permission management

### 2. Employee & Department Management
- Employee profiles
- Employee IDs
- Department management

### 3. Daily Menu Management
- Daily and weekly menus
- Food categories
- Menu history

### 4. Self-Service Meal Collection
- Employee ID-based meal collection
- QR code-based meal collection
- Duplicate meal prevention
- Meal collection history

### 5. Meal Demand Planning
- Expected meal quantity
- Actual meal collection
- Optional meal reservation

### 6. Recipe Management
- Recipe creation
- Ingredient management
- Serving-size configuration

### 7. Ingredient Calculator
- Portion-based ingredient calculation
- Automatic ingredient quantity estimation

### 8. Kitchen Management
- Food preparation schedules
- Kitchen staff assignments
- Task status tracking

### 9. Inventory Management
- Stock-in and stock-out
- Current stock balance
- Low-stock alerts

### 10. Expiry & FEFO Management
- Ingredient expiry tracking
- First-Expiry-First-Out (FEFO) stock handling

### 11. Supplier Management
- Supplier profiles
- Contact information
- Purchase history

### 12. Grocery Procurement
- Purchase requests
- Purchase orders
- Goods receiving
- Invoice management

### 13. Supplier Payment
- Full payments
- Partial payments
- Outstanding dues
- Payment methods
- Payment receipts

### 14. Special Event Management
- Event creation
- Participant management
- Event-specific menus

### 15. Catering Management
- Catering requests
- Catering preparation
- Catering fulfillment

### 16. Food Waste Management
- Prepared food quantity
- Collected food quantity
- Leftover food
- Spoiled food

### 17. Employee Feedback
- QR-based feedback
- Ratings
- Comments

### 18. Cafeteria Staff Management
- Staff profiles
- Work schedules
- Task assignments

### 19. Expense & Budget Management
- Grocery expenses
- Event expenses
- Operating costs
- Budget tracking

### 20. Dashboard & Reports
- Meal reports
- Inventory reports
- Purchase reports
- Supplier payment reports
- Food waste reports
- Expense reports

### 21. Smart Analytics
- Meal demand trends
- Food waste insights
- Meal demand forecasting

### 22. Sustainability Metrics
- Food waste reduction indicators
- Sustainability-related operational insights

### 23. AI Management Assistant
- Basic data-based management insights
- Management assistance prototype

## Main Actors

The planned system includes the following actors:

1. Employee
2. System Administrator
3. Cafeteria Manager
4. Kitchen Staff / Chef
5. Storekeeper / Inventory Officer
6. Procurement Officer
7. Finance / Accounts Officer
8. Catering / Event Coordinator
9. Management / Report Viewer

Suppliers may be modeled as external actors if direct system interaction is required.

## Important Business Rules

- Daily employee lunch is free.
- Employees collect their own meals through a self-service process.
- An employee must not collect the same day's lunch more than once.
- Meal demand and actual meal collection must be tracked separately.
- Recipes must define ingredient quantities per serving.
- Inventory changes through valid stock transactions.
- Expiring stock should follow FEFO principles.
- Supplier invoices and supplier payments must be tracked separately.
- Partial payments and outstanding dues must be supported.
- Special event and catering operations must be tracked separately from regular employee lunch operations.
- Prepared, collected, leftover, and spoiled food quantities should be recorded separately.

## Planned System Architecture

The application follows the ASP.NET Core MVC architectural pattern.

**Model**
- Represents application data and business entities.
- Examples: Employee, Department, FoodItem, Recipe, Supplier.

**View**
- Provides the user interface.
- Displays forms, dashboards, tables, and reports.

**Controller**
- Handles HTTP requests.
- Connects user actions with application logic.

**Service Layer**
- Contains reusable business logic.
- Examples: meal eligibility, ingredient calculation, inventory validation.

**Database**
- SQL Server will store application data.
- Entity Framework Core will be used for database operations.

### General Application Flow

User → MVC Controller → Service Layer → Model / Database → Controller → View → User

## Project Structure

The planned project structure is:

```text
SmartCorporateCafeteriaManagement/
│
├── Controllers/
│
├── Models/
│
├── Views/
│
├── Services/
│
├── Data/
│
├── wwwroot/
│   ├── css/
│   ├── js/
│   └── images/
│
├── Properties/
│
├── appsettings.json
│
└── Program.cs
```

The structure will evolve as development progresses.

## Getting Started

### Prerequisites

Install the following:

- Visual Studio 2022 or a compatible version supporting .NET 10
- .NET 10 SDK
- SQL Server (for the planned database integration)
- Git

### Run the Project

1. Clone the repository:

```bash
git clone YOUR_GITHUB_REPOSITORY_URL
```

2. Open the solution in Visual Studio.

3. Restore dependencies:

```bash
dotnet restore
```

4. Build the project:

```bash
dotnet build
```

5. Run the application:

```bash
dotnet run
```

6. Open the local URL displayed in the terminal.

> Database configuration, migrations, and connection strings will be added as the database implementation progresses.

## Current Development Status

**Project Status: In Development**

The project is being developed step by step as part of a practical learning and software development project.

### Completed Foundation Work

- ASP.NET Core MVC project created and running.
- Initial project structure explored.
- Employee model created.
- Department model created.
- FoodItem model created.
- Employee–Department relationship introduced.
- Initial C# business logic services created.
- Meal eligibility logic tested.
- Employee identification logic tested.
- Multiple employee meal checking tested.
- Inventory low-stock demonstration tested.
- Ingredient quantity calculation tested.

### Currently Working On

- C# classes and objects
- Properties and constructors
- Object initialization
- Model relationships
- Recipe and Supplier model design

### Upcoming Development

- Complete model design
- Entity Framework Core integration
- SQL Server database design
- Entity relationships and migrations
- Authentication and authorization
- CRUD operations
- Implementation of the 23 modules
- Integration testing
- Reporting and analytics
- Documentation and deployment preparation

**Note:** The items listed under planned modules are project requirements, not claims that all features have already been implemented.

## Development Approach

This project follows a learning-by-building approach.

Each development stage includes:

1. Learn the required programming concept.
2. Apply it to the actual project.
3. Understand the code and its purpose.
4. Build and test the implementation.
5. Fix errors and document solutions.
6. Track development progress.

## Future Improvements

- Advanced demand forecasting
- More comprehensive analytics
- Improved dashboard visualizations
- Enhanced AI-based management insights
- Production deployment and security improvements

## Author

Developed as a practical software development project using C#, .NET, ASP.NET Core MVC, and SQL Server.

## License

This project is currently developed for educational and practical demonstration purposes. Licensing terms can be added when the project is published.
