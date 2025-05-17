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

---

## ⚙️ Tech Stack

### Backend
- [Laravel](https://laravel.com) 11+
- Laravel Breeze (Authentication)
- Inertia.js (Frontend communication)
- PostgreSQL
- Spatie Permissions
- Dedoc/Scramble (for API documentation)

### Frontend (Admin Panel)
- Vue.js with Inertia.js
- Tailwind CSS
- Laravel Vite

### Mobile App
- React Native
- Expo Go
- NativeWind

### DevOps
- GitHub Actions (CI/CD)
- Deployer
- Ansible
- Hosted on OpenStack (Linux server)
- 3-2-1 backup strategy in place

---

## 📂 Project Structure

- `/app` – Laravel application logic (controllers, models, policies, etc.)
- `/resources/js` – Inertia.js pages and components
- `/routes` – Web and API routes
- `/database` – Migrations, factories, and seeders
- `/public/docs` – API documentation generated with Dedoc/Scramble

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

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🙏 Acknowledgements

Special thanks to:
- My mentors and reviewers
- The Laravel and React Native communities
- All beta testers for their feedback
- The board gaming community for the inspiration ❤️

---

> LudiceWEB is developed with passion for the gaming community – because game nights deserve great tools. 🎲
