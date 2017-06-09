### Write 10 lines about how this application could support fetching data from other sources than GitHub. 

This app is very light and add support for fetching another data is easy. Everything depends on expected result. 
We can create seperate instances of tables and forms, and in most situations it will be the best option. Of course we should move reusable part of code to parent.
But if we only need to diplay data from other sources, and keep search history we could add select input to search with "data source" (like StackOverflow Persons, LinkedIn Persons...)
and simply change ajax URL for fetching data. Table structure could be unified (eg. image if exist, name, count) or defined (for each query different columns) or dynamic (base on response).
**RecentSearch** model only need to be extended about "data_source" with foregin key to **DataSource** (id, name, url_template if we decided to create dynamic table). 

If we decided to create dynamic tables with url_templates, extend Web App about next API will only need add new entity to **DataSource**. 
Of course, there could be problem with input data (different count of params), so maybe we also should extend **DataSource** structure to keep information about count of inputs and their types? 
There is tons on possibilities.

### Let us say we wanted to fetch data from Stack Overflow and LinkedIn too. How should this be done with tables in a database, organising code in classes in the project, etc.

There is serveral options to do that, depends on result want to achieve. Both sites have their own APIs - [StackExchange](https://api.stackexchange.com/docs) | [LinkedIn](https://developer.linkedin.com/docs/rest-api).
So the most flexible way to collect data from those sites is use theirs APIs.

In LinkedIn structure is easier because we can create for example two Models:
- Person
- Company
And bind them with results from API calls. Sample Person response
```
{
  "firstName": "Frodo",
  "headline": "Jewelery Repossession in Middle Earth",
  "id": "1R2RtA",
  "lastName": "Baggins",
  "siteStandardProfileRequest": {
    "url": "https://www.linkedin.com/profile/view?id=…"
  }
}
```
So **Person** model could look like:
- id *(int)*
- external_id *(varchar)*
- first_name *(varchar)*
- last_name *(varchar)*
- headline *(text)*
- url *(varchar 255)*
- created_at *(datetime)*
- updated_at *(datetime)*

Response structure from this API is clear, so Model structure is also obvious. 

More difficult is organize data from StackOverflow API, because there is a lot of things we would like to store. Most of responses contains user data:
```
...
"owner": {
        "reputation": 2485,
        "user_id": 8710,
        "user_type": "registered",
        "accept_rate": 75,
        "profile_image": "https://www.gravatar.com/avatar/9e505829a0733110fe0b6cb3bfb6ac47?s=128&d=identicon&r=PG",
        "display_name": "mqsoh",
        "link": "https://stackoverflow.com/users/8710/mqsoh"
      },
...
```
So base on this response, we could create **User** model could look like
- id *(int)*
- external_id *(int)*
- display_name *(varchar)*
- url *(varchar)*
- image_url *(varchar 255)*
- user_type *(varchar/int)* - here we could create **UserType** (dictionary) populated when not found entry in database and connect it by foreign key with user_type. Everything depends on expected results
- accept_rate *(int)*
- reputation *(int)*

Stackoverflow structure is huge so architecture depends on expected result. Sometimes the best way could be import the latest SQL backup from https://archive.org/details/stackexchange then we can do everything.
