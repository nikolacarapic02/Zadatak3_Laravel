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

- Show all users, role:admin

```http
GET /users
```
- Show one user, role:admin, recruiter, mentor

```http
GET /users/{id}
```
- Show the logged in user, role:admin, recruiter, mentor

```http
GET /users/me
```
- Verifying user, role:admin, recruiter, mentor

```http
GET /users/verify/{token}
```
- Resend verification link to user, role:admin, recruiter, mentor

```http
GET /users/{id}/resend
```
- Create new user, role:admin

```http
POST /users
```

- Update user, role:admin

```http
PUT /users/{id}
```

- Change user role, role:admin

```http
PUT /users/{id}/changerole
```

- Delete user, role:admin

```http
DELETE /users/{id}
```

### Mentors

- Show all mentors, role:admin, recruiter

```http
GET /mentors
```
- Show one mentor, role:admin, recruiter, mentor

```http
GET /mentors/{id}
```

- Show all assignments for this mentor, role:admin, recruiter, mentor

```http
GET /mentors/{mentor_id}/assignments
```

- Clone assignment to other group, role:admin, mentor

```http
GET /mentors/{mentor_id}/assignments/{assignment_id}/groups/{groups_id}/clone
```

- Show all groups for this mentor, role:admin, recruiter, mentor

```http
GET /mentors/{mentor_id}/groups
```

- Show all interns for this mentor, role:admin, recruiter, mentor

```http
GET /mentors/{mentor_id}/interns
```

- Show all reviews for this mentor, role:admin, recruiter, mentor

```http
GET /mentors/{mentor_id}/reviews
```

- Mentor create assignment, role:admin, mentor

```http
POST /mentors/{mentor_id}/assignments
```

- Mentor create review for intern, role:admin, mentor

```http
POST /mentors/{mentor_id}/interns/{intern_id}/reviews
```

- Update mentor, role:admin, recruiter, mentor

```http
PUT /mentors/{id}
```

- Mentor update assignment, role:admin, mentor

```http
PUT /mentors/{mentor_id}/assignments/{assignment_id}
```

- Mentor update review, role:admin, mentor

```http
PUT /mentors/{mentor_id}/interns/{intern_id}/reviews/{review_id}
```

- Mentor delete assignment, role:admin, mentor

```http
DELETE /mentors/{mentor_id}/assignments/{assignment_id}
```

- Mentor delete review, role:admin, mentor

```http
DELETE /mentors/{mentor_id}/interns/{intern_id}/reviews/{review_id}
```

### Interns

- Show all interns, role:admin, recruiter, mentor

```http
GET /interns
```

- Show one intern, role:admin, recruiter, mentor

```http
GET /interns/{id}
```

- Show all active assignments for this intern, role:admin, recruiter, mentor

```http
GET /interns/{intern_id}/assignments
```

- Show all mentors for this intern, role:admin, recruiter, mentor

```http
GET /interns/{intern_id}/mentors
```

- Show all groups for this intern, role:admin, recruiter, mentor

```http
GET /interns/{intern_id}/groups
```

- Show all reviews for this intern, role:admin, recruiter, mentor

```http
GET /interns/{intern_id}/reviews
```

- Create intern, role:admin, recruiter

```http
POST /interns
```

- Update intern, role:admin, recruiter

```http
PUT /interns/{id}
```

- Delete intern, role:admin, recruiter

```http
DELETE /interns/{id}
```

### Groups

- Show all groups, role:admin, recruiter

```http
GET /groups
```

- Show one group, role:admin, recruiter, mentor

```http
GET /groups/{id}
```

- Show all mentors for this group, role:admin, recruiter, mentor

```http
GET /groups/{group_id}/mentors
```

- Show all interns for this group, role:admin, recruiter, mentor

```http
GET /groups/{group_id}/interns
```

- Show all assignments for this group, role:admin, recruiter, mentor

```http
GET /groups/{group_id}/assignments
```

- Create group, role:admin, recruiter

```http
POST /groups
```

- Update group, role:admin, recruiter

```http
PUT /groups/{id}
```

- Add mentor in gorup, role:admin, recruiter

```http
PUT /groups/{group_id}/addmentor
```

- Delete mentor from group, role:admin, recruiter

```http
PUT /groups/{group_id}/deletementor
```

- Activate assignment in group, role:admin, recruiter, mentor

```http
PUT /groups/{group_id}/assignments/{assignment_id}/activate
```

- Delete group, role:admin, recruiter

```http
DELETE /groups/{id}
```

### Assignments

- Show all assignments, role:admin, recruiter

```http
GET /assignments
```

- Show one assignment, role:admin, recruiter, mentor

```http
GET /assignments/{id}
```

- Show all mentors for this assignments, role:admin, recruiter, mentor

```http
GET /assignments/{assignment_id}/mentors
```

- Show all interns for this assignments, role:admin, recruiter, mentor

```http
GET /assignments/{assignment_id}/interns
```

- Show all groups for this assignments, role:admin, recruiter, mentor

```http
GET /assignments/{assignment_id}/groups
```

- Show all reviews for this assignments, role:admin, recruiter, mentor

```http
GET /assignments/{assignment_id}/reviews
```

### Reviews

- Show all reviews, role:admin, recruiter

```http
GET /reviews
```

- Show one reviews, role:admin, recruiter, mentor

```http
GET /reviews/{id}
```

- Show all mentors for this review, role:admin, recruiter, mentor

```http
GET /reviews/{review_id}/mentors
```

- Show all interns for this review, role:admin, recruiter, mentor

```http
GET /reviews/{review_id}/interns
```

- Show all assignments for this review, role:admin, recruiter, mentor

```http
GET /reviews/{review_id}/assignments
```

### Authentication

- Authorize user

```http
POST /oauth/token
```

## WEB References

- Home page

```http
GET /home
```
