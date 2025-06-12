<p align="center">
  <img src="https://ludice.app/logo.png" width="200" alt="Ludice Logo">
</p>


<p align="center">
  <strong>LudiceWEB</strong> – A companion app for board game enthusiasts.
</p>

---

## 🧩 About LudiceWEB

**LudiceWEB** is a full-stack web application designed to help board game lovers manage their game collections, log play sessions, and interact with their gaming group more easily. Developed as part of a final-year project, it offers a practical, elegant, and community-driven solution for tabletop gamers.

This web app is the backend and admin interface of a broader Ludice ecosystem that includes a mobile application (React Native). The Laravel-based service provides an API-first architecture, complete with a clean admin panel and automated CI/CD deployment.

---

## 🚀 Features

- 🎲 Manage a personal board game library
- 🔄 Select a random game based on filters
- 🧑‍🤝‍🧑 Choose a first player randomly
- 📝 Record and view scores per game session
- 🛠️ Admin interface for adding/editing games, mechanics, categories, creators, and publishers
- 📦 RESTful API built with Laravel + Inertia.js
- 📱 Mobile app available (React Native + Expo)
- 🔐 Authentication with Laravel Breeze
- 🧼 Clean and consistent UI using TailwindCSS

---

## 💻 Feature to develop

- ⭐ Rate and comment on games  
- 📈 Increase code coverage to 100%

<p align="center">
    <img 
      src="https://codecov.io/gh/Tod2a/ludiceWeb/branch/develop/graph/badge.svg?token=YJ2ZXB9WUC" 
      alt="Codecov coverage badge" 
      style="width: 150px; height: auto;"
    />
</p>

---

## ⚙️ Tech Stack

### Backend
- [Laravel](https://laravel.com) 11+
- Laravel Breeze (Authentication)
- Inertia.js (Frontend communication)
- PostgreSQL
- Spatie Laravel Backup – Automated backup scheduling
- Dedoc/Scramble (for API documentation)

### Frontend 
- Vue.js with Inertia.js
- Tailwind CSS
- Laravel Vite

### Mobile App (separate repo)
- React Native
- Expo Go
- NativeWind

### DevOps
- GitHub Actions (CI/CD)
- Deployer
- Ansible (separate repo)
- Hosted on OpenStack (Linux server)
- 3-2-1 backup strategy in place

---

## 📂 Project Structure

- `/app` – Core Laravel application logic (models, controllers, policies, services, etc.)
- `/config` – Configuration files for the application and services
- `/database` – Database migrations, model factories, and seeders
- `/lang` – Localization files for translations
- `/public` – Publicly accessible assets (CSS, JS, images) and generated API documentation available at `/docs`
- `/resources/js` – Frontend Inertia.js pages and Vue/React components
- `/routes` – Web and API route definitions (`web.php`, `api.php`, etc.)
- `/storage` – Application storage for logs, cached files, and user uploads
- `/tests` – Automated tests (feature, unit, browser tests)

---

## 📦 Installation

1. Clone the repo:
```bash
git clone https://github.com/Tod2a/ludiceWeb.git
cd ludiceWEB
```

2. Install dependencies:
```bash
composer install
npm install && npm run build
```

3. Set up `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations:
```bash
php artisan migrate --seed
```

5. Launch the dev server:
```bash
php artisan serve
```

---

## 🔐 Google Analytics

The admin dashboard includes usage statistics (like app starts and game selections) powered by Google Analytics 4.  
To enable this feature locally, you need to provide a credentials file:

```

storage/app/analytics/credentials.json

```

Without this file:
- The **Analytics section** of the dashboard will not work locally.
- The **rest of the application** will still function as expected.

> If you're only developing features unrelated to the dashboard, you can ignore this file.

---

## 📖 API Documentation

The API documentation is auto-generated using Dedoc/Scramble and accessible at:
```
https://your-domain.com/docs
```
---

## 📱 Mobile App

The mobile app connects to the same API and is maintained in a separate repo: `ludiceApp`.
You can preview it using Expo Go.

---

## 🙏 Acknowledgements

Special thanks to:
- My mentors and reviewers
- The Laravel and React Native communities
- All beta testers for their feedback
- The board gaming community for the inspiration ❤️

---

> LudiceWEB is developed with passion for the gaming community – because game nights deserve great tools. 🎲
