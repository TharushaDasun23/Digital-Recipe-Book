
## Phase 1 Deliverables

## Wireframes:
## 1.	Includes Home Page

•	**Header & Identity:** Features the official brand logo alongside explicit text links navigation (Home, Recipes, Contact) and an outstanding accent template button for Login functionality.

•	**clean Hero Search Segment:** Houses a prominent search box layout tailored for real-time JavaScript text processing.

•	**Dynamic Recipes Grid:** Organizes featured recipe cards dynamically using spacing, complete with structured "View Recipe" actionable pointer cards.


## 2.	Recipe View

•	**Visual & Temporal Data:** Contains dedicated metadata headers for recipe nomenclature (e.g., Chicken Kottu Roti), local origin variables, prep times, and total serving yields. 

•	**Relational Ingredients Dataset:** A clean, dual-column layout mapping system designed to fetch metric amounts (grams, stalks, spoons) dynamically from the MySQL database. 

•	**Sequential Instructions Array:** Uses an ordered list structure to present step-by-step cooking directions clearly, paired with thumbnail carousel dots for easy tracking. 


## 3.	Contact Page layouts

•	**Central Form Wrapper:** Features an isolated interactive form structure containing input blocks explicitly arranged for capturing user data. 

•	**Database Target Fields:** Includes field parameters for Name, Email, Subject, and an extended Message text area. 

•	**Action Hook:** Concludes with an explicit [Submit Button] — Send Message element mapped out to trigger validation checks and safely push strings to the backend MySQL database server. 
 Next Production Steps

We have successfully finalized our conceptual blueprints, structural requirements, and 3-page visual wireframes for Phase 1 of the project. This note outlines our immediate production roadmap as we transition into the next development phases.

## Upcoming Development Roadmap

**1. Frontend Layout & Responsive Design** 

Grid Mapping : We will translate our layout frames into fully structured HTML pages using the Bootstrap 5 grid system to guarantee a fully responsive design across all devices (mobile, tablet, and desktop viewports )
UI Elements:We will implement standardized navigation frameworks, responsive content card layouts, and uniform footers across the site 
Client-Side Interactions:JavaScript scripts will be programmed to handle dynamic content queries, form field inputs, and real-time interface updates 

**2. Backend Engine & Relational Database Integration**

MySQL Database Schema:We will build a local MySQL database structure via XAMPP to map our system layouts and data models.
PHP Server Logic Processing: Secure PHP 8 backend scripts will be created using prepared statements to safely process user forms and capture database entries.
Authentication & Session Handling: We will deploy secure PHP session routines to monitor login actions and maintain safe user authentication states.





## Phase 2 – Frontend Layout & Design 


## VeganFood - Digital Cookbook 

An interactive and responsive plant-based recipe application for ICT 1209: Web Technologies mini-project. 


 ## Technology Stack

- **Frontend:** HTML5, CSS3, Bootstrap 5 
- **Scripting:** JavaScript 
- **Version Control:** GitHub
  

## JavaScript Features

01. **Search & Filter:** Search recipes by name and filter by category without reloading (js/search.js, js/filter.js).
02. **Dark Mode:** Dark and light theme switcher that saves user preference (js/theme.js).
03. **Form Validation:** Real-time validation for user input forms (js/validation.js).
04. **UI Animations:** Card hover animations and scroll-to-top button (js/hover.js, js/scroll.js).



### Key Bootstrap Components Used:

**1.Responsive Navigation Bar (.navbar-expand-lg):**

The mobile menu can be. Opened with a button.

The brand name is in a spot and the navigation links are lined up nicely.

**2.Grid. Layout (.container.row.col-):**

We used this in the index.html. Recipes.html files to make a layout with many columns that works well on phones, tablets and computers.

**3.Card Component (.card,.card-img-.card-body):**

We used this for all the recipes and added a shadow and rounded corners to make it look nice.

**4.Form Controls & Input Groups (.form-control,.input-group):**

We styled the search bars and contact forms to look good and work well with Bootstrap.

**5.Action Buttons (.badge,.btn):**

We made the buttons look nice and added badges to show what type of food it is.

**6.Bootstrap Utility Classes:**

*Flexbox Utilities*: We used these to line up things on the page.

*Spacing Utilities*: We used these to make sure things have the amount of space around them.

 


## CSS Implementation / Styling Approach

01.**Bootstrap 5 Integration:** Primary layout styling and dynamic validation states (`is-valid` / `is-invalid`) are handled using Bootstrap 5 utility classes.

02.**Inline Custom Styling:** Component-specific custom styling and quick layout adjustments were implemented using inline CSS to ensure component isolation and direct control over design constraints.

03.**External Scripts Integration:** Interactive states styled dynamically via JS validation (`validation.js` and `search.js`).




## Phase 3 
##(Backend & Database Integration)

### Overview
Phase 3 transitions the frontend website into a fully functional dynamic web application using *PHP* and *MySQL*.

### Core Implementation
* *Database Management (database.sql):* SQL script containing schema for users, recipes, and contact_messages tables.
* *Database Connectivity (includes/db.php):* Centralized MySQLi connection helper.
* *Authentication System (auth/):*
  01.* register.php: New user registration with password hashing (password_hash).
  02.* login.php: Secure session-based authentication.
  03.* logout.php: Session destruction and secure redirect.





## Team Members :

**- Name        :** T.M.V.L Weerasekara
**- Index No    :** 2798

**- Name        :** H.T.T.D Nishantha
**- Index No    :** 2761
