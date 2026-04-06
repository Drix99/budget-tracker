# Budget Tracker for Students

A comprehensive budget tracking application built with Laravel to help students manage their finances effectively.

## Features

- **Transaction Management**: Add, edit, and delete income and expense transactions
- **Category Management**: Create and organize transactions into custom income and expense categories
- **Financial Dashboard**: View total income, total expenses, and current balance at a glance
- **Transaction History**: Browse recent transactions with category labels and amounts
- **User Authentication**: Secure login and registration using Laravel Breeze
- **Responsive Design**: Mobile-friendly interface built with Tailwind CSS
- **Data Persistence**: SQLite database for reliable data storage

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

1. Register or login with your credentials
2. Navigate to the Dashboard to view your financial summary
3. Go to Transactions to add new income/expense entries
4. Manage Categories - create categories for better organization
5. Track your spending patterns and balance over time

## Database Schema

### Users Table
- Stores user authentication information

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
