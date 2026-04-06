# Budget Tracker for Students

A comprehensive budget tracking application built with Laravel to help students manage their finances effectively.

## Features

- **Transaction Management**: Add, edit, and delete income and expense transactions
- **Category Management**: Create and organize transactions into custom income and expense categories
- **Weekly Budget Tracking**: Set weekly spending limits and monitor remaining budget in Philippine pesos (₱)
- **Smart Spending Insights**: Get intelligent alerts when approaching budget limits (70-80%+)
- **Budget Predictions**: View estimated days until budget depletion based on spending patterns
- **Visual Analytics**: Category pie charts and 7-day spending trends
- **Financial Dashboard**: Comprehensive view with income, weekly spending, budget status, and insights
- **Transaction History**: Browse recent transactions with category labels and amounts
- **Email Verification**: Secure registration with email verification flow
- **User Authentication**: Secure login and registration using Laravel Breeze
- **Responsive Design**: Mobile-friendly interface with dark mode support
- **Data Persistence**: MySQL/SQLite database for reliable data storage

## Tech Stack

- **Backend**: Laravel 11 (PHP Framework)
- **Database**: SQLite
- **Frontend**: Blade Templates, HTML, CSS
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **Authentication**: Laravel Breeze

## Installation

1. Clone the repository
2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Run database migrations and seed default categories:
   ```bash
   php artisan migrate --seed
   ```

6. Build front-end assets:
   ```bash
   npm run build
   ```

## Running the Application

### Development Server (with Hot Reload)
```bash
npm run dev
```

This will start the Vite development server with hot module reloading.

### Production Build
```bash
npm run build
```

### Serve the Application
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Test Credentials

- **Email**: test@example.com
- **Password**: password

## Usage

1. **Register**: Create an account with your email and verify your email address
2. **Login**: Access your account with verified credentials  
3. **Dashboard**: View your weekly financial summary including:
   - Total income and weekly spending
   - Weekly budget status and remaining budget
   - Budget alerts when approaching limits
   - Smart spending predictions
   - Category spending breakdown (pie chart)
   - 7-day spending trend (line chart)
4. **Add Transactions**: Click "Add Expense" to record income or expenses
5. **Manage Categories**: Organize your transactions by creating custom categories
6. **Set Budget**: In the dashboard's "Smart Insights" section, set your weekly spending budget
7. **Track Patterns**: Review charts and insights to understand your spending habits

## Dashboard Insights

- **Budget Alerts**: Automatic warnings at 70% (approaching) and 80%+ (caution) of your weekly budget
- **Spending Patterns**: See which categories consume the most of your budget
- **Daily Trends**: Visual 7-day history shows your daily spending patterns
- **Predictions**: Estimated days until budget exhaustion based on current spending rate

## Database Schema

### Users Table
- Stores user authentication information
- Includes email verification timestamp

### Categories Table
- `id`: Primary key
- `name`: Category name (e.g., "Groceries", "Salary")
- `type`: Either "income" or "expense"
- `timestamps`: Created and updated timestamps

### Transactions Table
- `id`: Primary key
- `user_id`: Reference to user
- `category_id`: Reference to category
- `amount`: Transaction amount
- `description`: Optional transaction notes
- `date`: Transaction date
- `timestamps`: Created and updated timestamps

### Budgets Table
- `id`: Primary key
- `user_id`: Reference to user (one budget per user)
- `weekly_budget`: The weekly spending limit in Philippine pesos
- `timestamps`: Created and updated timestamps

## API Routes

All routes are protected with authentication middleware.

### Transactions
- `GET /transactions` - List all transactions
- `GET /transactions/create` - Show create form
- `POST /transactions` - Store new transaction
- `GET /transactions/{id}/edit` - Show edit form
- `PATCH /transactions/{id}` - Update transaction
- `DELETE /transactions/{id}` - Delete transaction

### Categories
- `GET /categories` - List all categories
- `GET /categories/create` - Show create form
- `POST /categories` - Store new category
- `GET /categories/{id}/edit` - Show edit form
- `PATCH /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category

## Default Categories

### Income
- Salary
- Freelance
- Investments
- Bonus
- Other Income

### Expenses
- Groceries
- Utilities
- Rent
- Transportation
- Entertainment
- Dining Out
- Shopping
- Healthcare
- Education
- Other Expenses

## Future Enhancements

- Spending analytics with charts and graphs
- Budget goal setting and tracking
- CSV export functionality
- Monthly/yearly reports
- Recurring transaction automation
- Mobile app version

## License

This project is licensed under the MIT License.
