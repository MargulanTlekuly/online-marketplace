# Online Marketplace

Student Web Programming Project — a complete multi-page e-commerce website built with **HTML, CSS and PHP only** (no JavaScript). All data is stored in JSON files.

## Features (matches the 19 project requirements)

1. User registration & authentication with password hashing (`password_hash`) and PHP sessions
2. Home page with hero section, category tiles, feature highlights and featured products
3. Consistent navigation bar (with active-state highlighting) and footer on every page
4. Full e-commerce flow: Home -> Catalog (search + category filter + sorting) -> Product details -> Add to cart -> Checkout -> Confirmation -> Profile
5. Shopping cart with quantity updates and remove
6. Checkout form with delivery address / phone / payment method / notes (server-side validation)
7. Order confirmation page with order number, date and total
8. User profile with real **Edit Profile** (name, email, phone, address) and order history
9. Admin panel with sidebar layout:
   - Dashboard with statistics (users, products, orders, pending, revenue)
   - Users list with avatars, roles, order counts
   - Products CRUD (Add / Edit / Delete with safe confirmation page)
   - Orders management with status change (pending / confirmed / cancelled)
10. 20 sample products with placeholders for product images (you add the photos)
11. Server-side form validation with 5+ error scenarios
12. Search, category filter, and sort (price/rating/name)
13. Responsive design (desktop, tablet, mobile) using media queries, Flexbox and CSS Grid
14. Consistent design system (CSS variables, shared header/footer, typography, buttons, cards)
15. Footer with working About/Contact/Privacy/Terms/FAQ pages
16. Proper project structure (`admin/`, `includes/`, `css/`, `js/`, `images/`, `data/`, `pages/`)
17. Semantic HTML, forms, links, images, tables, lists
18. CSS selectors, box model, Flexbox, Grid, media queries, hover effects, transitions

## Tech stack

- HTML5 (semantic tags, forms, tables)
- CSS3 (custom properties, Flexbox, CSS Grid, media queries, transitions)
- PHP (sessions, server-side validation, JSON storage, includes)
- JSON file storage (`data/users.json`, `data/products.json`, `data/orders.json`)

**No JavaScript is used.** All interactivity is handled with PHP forms and standard page reloads, as requested.

## Project structure

```
online-marketplace/
├── index.php              Home page
├── login.php              Login
├── register.php           Registration
├── catalog.php            Product catalog (search + filter + sort)
├── product.php            Product details page
├── cart.php               Shopping cart
├── checkout.php           Checkout form
├── confirmation.php       Order confirmation
├── profile.php            User profile + Edit Profile + order history
├── logout.php             Logout
├── admin/
│   ├── index.php          Admin dashboard
│   ├── users.php          Users list
│   ├── products.php       Products list
│   ├── product_form.php   Add / edit product form (CRUD - Create/Update)
│   ├── product_delete.php Delete product confirmation page (CRUD - Delete)
│   └── orders.php         Orders list with status change
├── includes/
│   ├── header.php         Shared top navigation
│   ├── footer.php         Shared footer
│   └── functions.php      Helper functions (data load/save, auth, rendering)
├── pages/
│   ├── about.php          About page
│   ├── contact.php        Contact form
│   ├── privacy.php        Privacy Policy
│   ├── terms.php          Terms of Service
│   └── faq.php            FAQ
├── css/
│   └── style.css          All styles
├── js/
│   └── README.md          (no JavaScript used; folder exists to match the required structure)
├── data/
│   ├── users.json         Registered users
│   ├── products.json      20 sample products
│   └── orders.json        Customer orders
├── images/
│   ├── logo.png           Logo (optional - page works without it)
│   └── items/             Drop product photos here as 1.jpg ... 20.jpg
└── README.md
```

## How to add product photos

The catalog is pre-populated with 20 products. The site looks for product photos at:

```
images/items/1.jpg
images/items/2.jpg
...
images/items/20.jpg
```

Just place your image files (JPG/PNG) into `images/items/` named `1.jpg` through `20.jpg`. Until you do, the site shows a clean placeholder tile with the product number and the filename so you can see exactly where each photo will appear.

You can also customise the image path for any product from the admin panel (`Admin > Products > Edit > Image Path`).

## How to add icons / logo

- Logo: drop a file at `images/logo.png` OR change the `<span class="brand-mark">M</span>` letter in `includes/header.php` to any other letter/text. The brand mark is a CSS-styled square - no image required.
- Social icons in the footer are currently text labels (IG / FB / TG). Replace them with `<img>` tags pointing at files in `images/icons/` if you wish to add social icons later.
- All decorative icons (features on the home page, category tiles, info cards, search "icon", avatars) are **pure CSS shapes and text** so you do NOT need to download any icon files.

## How to run

1. Install XAMPP (Apache + PHP 7.4+).
2. Start Apache.
3. Copy this project folder to `xampp/htdocs/marketplace`.
4. Open in browser: `http://localhost/marketplace/`

## Admin access

1. Register a new account from the Register page.
2. Open `data/users.json`, find your account, and change `"role": "user"` to `"role": "admin"`.
3. Log in as that user. An "Admin" link will appear in the navigation.

## Test demo

- Register with any email/password (password must be at least 6 characters).
- Or edit `data/users.json` manually to create an admin account.

---

© 2026 Online Marketplace — Student Web Programming Project.
