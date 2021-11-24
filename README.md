<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Api

This api was created in the PHP programming language, using the Laravel framework.

Api uses the OAuth2 authentication system, which is achieved by using the [Laravel Passport](https://laravel.com/docs/8.x/passport) package.

The next chapter will explain in detail the process of downloading and launching the application itself.

## How to download and run the app?

### Git clone

- In terminal access to your local server environment root directory or another folder where you want to make a clone.

- Run
```
    git clone https://github.com/nikolacarapic02/Zadatak3_Laravel.git
```

- Another way is to click on the code button on the github repository page and then click on the [Download Zip](https://github.com/nikolacarapic02/Zadatak3_Laravel/archive/refs/heads/master.zip) option in the menu that appears.

### Usage

- The first thing you need to do is access the file where the application is located via the terminal.

- If you do not have Laravel installed on your computer, you can do so via this [link](https://laravel.com/docs/4.2), where the whole procedure is explained in detail.

- Then you need to create a database and name it will be the same as it did in the laravel application in the: .evn.example file, item DB_DATABASE.

- After that, in the terminal it is necessary to write the command ```php artisan migrate --seed```, which will create all the necessary tables in the database and fill them with random data.

- Then you need to use the laravel passport to generate a token to go through the authentication process.

- Finally in application launch environment, use one of the routes listed in the [Api References](#api-references) or [Web References](#web-references) section.

## API References

### Users

- Show all users

```http
GET /users
```
- Show one user

```http
GET /users/{id}
```
- Show the logged in user

```http
GET /users/me
```
- Verifying user

```http
GET /users/verify/{token}
```
- Resend verification link to user

```http
GET /users/{user}/resend
```
- Create new user

```http
POST /users
```

- Update user

```http
PUT|PATCH /users/{id}
```

- Change user role

```http
PUT /users/{user}/changerole
```

- Delete user

```http
DELETE /users/{id}
```

### Mentors

- Show all mentors

```http
GET /mentors
```
- Show one mentor

```http
GET /mentors/{id}
```

- Show all assignments for this mentor

```http
GET /mentors/{mentor_id}/assignments
```

- Clone assignment to other group

```http
GET /mentors/{mentor_id}/assignments/{assignment_id}/groups/{groups_id}/clone
```

- Show all groups for this mentor

```http
GET /mentors/{mentor_id}/groups
```

- Show all interns for this mentor

```http
GET /mentors/{mentor_id}/interns
```

- Show all reviews for this mentor

```http
GET /mentors/{mentor_id}/reviews
```

- Mentor create assignment

```http
POST /mentors/{mentor_id}/assignments
```

- Mentor create review for intern

```http
POST /mentors/{mentor_id}/interns/{intern_id}/reviews
```

- Update mentor

```http
PUT|PATCH /mentors/{id}
```

- Mentor update assignment

```http
PUT|PATCH /mentors/{mentor_id}/assignments/{assignment_id}
```

- Mentor update review

```http
PUT|PATCH /mentors/{mentor_id}/interns/{intern_id}/reviews/{review_id}
```

- Mentor delete assignment

```http
DELETE /mentors/{mentor_id}/assignments/{assignment_id}
```

- Mentor delete review

```http
DELETE /mentors/{mentor_id}/interns/{intern_id}/reviews/{review_id}
```

### Interns

