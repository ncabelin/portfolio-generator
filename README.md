# Portfolio Generator
Generate portfolio content dynamically using the LAMP stack

### MODEL
```
Contacts
|____ id
|____ title
|____ description
|____ url

Skills
|___ id
|___ name
|___ level

Projects
|___ id
|___ title
|___ type ---> FullStack, Wordpress, Micro-services, Games, Other
|___ github_url
|___ live_url
|___ details

Skill_Project
|___ id
|___ project_id FOREIGN KEY
|___ skill_id FOREIGN KEY
```
