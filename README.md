# Covid19 Vaccination Appointments
The goal of this project is to build a web-based system for signing up people for COVID-19 vaccinations. The first part of this project is to design and build a database for the system and the second part is to create a web-based user interface and implement the features.

## Database Design (Relational Schema)
First, there are three types of participants: patients, providers and administrators (we assume that admins can directly access database).
Patients can sign up in the system, and provide necessary information. Patietns can also choose their time preference and distance preference for the vaccination.
Patients can choose to accept/decline an vaccination offer and cancel an offer afterwards.

Providers can also sign up in the system, and provide necessary information. They can also add appointments, update appointments status and look up appointment info.
The system will match available appointments with patients according to their preference periodically.

The following are the ER DIAGRAM for the relational schema.




## Website Implementation 

