---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/docs/collection.json)

<!-- END_INFO -->

#Task management


API for managing tasks
<!-- START_53be1e9e10a08458929a2e0ea70ddb86 -->
## View tasks list

Get task list by search value, sort them by order and paginate(10 tasks per page maximum).

> Example request:

```bash
curl -X GET \
    -G "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/?search=mytask1&order_by=due_date&order_dir=desc&page=2" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/"
);

let params = {
    "search": "mytask1",
    "order_by": "due_date",
    "order_dir": "desc",
    "page": "2",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET /`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `search` |  optional  | string The string to search in title field.
    `order_by` |  optional  | string To sort by this field.
    `order_dir` |  optional  | string To set direction of sorting.
    `page` |  optional  | To redirect to current page.

<!-- END_53be1e9e10a08458929a2e0ea70ddb86 -->

<!-- START_67dc355ff092054220edfb9d8292af16 -->
## Edit task by id

Edit task by id. On success redirects to paginated, sorted view of tasks

> Example request:

```bash
curl -X PUT \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/12?order_by=priority&order_dir=asc&page=3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"editedtasktitle","due_date":"2019-12-17 20:11:07","priority_id":3}'

```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/12"
);

let params = {
    "order_by": "priority",
    "order_dir": "asc",
    "page": "3",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "editedtasktitle",
    "due_date": "2019-12-17 20:11:07",
    "priority_id": 3
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT {id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the task.
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `order_by` |  optional  | string To sort by this field.
    `order_dir` |  optional  | string To set direction of sorting.
    `page` |  optional  | int To redirect to current page.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | The title of edited task.
        `due_date` | timestamp |  required  | The due date of edited task.
        `priority_id` | integer |  required  | The id of priority of edited task.
    
<!-- END_67dc355ff092054220edfb9d8292af16 -->

<!-- START_f0e85c6018721b104e81a7b978548aab -->
## Delete task by id

Deletes task by id. On success redirects to page1 unsorted tasks list

> Example request:

```bash
curl -X DELETE \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/4" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/4"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE {id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the task.

<!-- END_f0e85c6018721b104e81a7b978548aab -->

<!-- START_5e901bbc73b2f95e077625c8fdf1a97a -->
## Adds new task

Adds new task to tasks list and redirects to unsorted page #1 of tasks

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"title":"added task title","due_date":"2019-12-17 20:11:07","priority_id":2}'

```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "added task title",
    "due_date": "2019-12-17 20:11:07",
    "priority_id": 2
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST /`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `title` | string |  required  | The title of added task.
        `due_date` | timestamp |  required  | The due date of added task.
        `priority_id` | integer |  required  | The id of priority of added task.
    
<!-- END_5e901bbc73b2f95e077625c8fdf1a97a -->

#general


<!-- START_66e08d3cc8222573018fed49e121e96d -->
## Show the application&#039;s login form.

> Example request:

```bash
curl -X GET \
    -G "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET login`


<!-- END_66e08d3cc8222573018fed49e121e96d -->

<!-- START_ba35aa39474cb98cfb31829e70eb8b74 -->
## Handle a login request to the application.

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST login`


<!-- END_ba35aa39474cb98cfb31829e70eb8b74 -->

<!-- START_e65925f23b9bc6b93d9356895f29f80c -->
## Log the user out of the application.

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST logout`


<!-- END_e65925f23b9bc6b93d9356895f29f80c -->

<!-- START_ff38dfb1bd1bb7e1aa24b4e1792a9768 -->
## Show the application registration form.

> Example request:

```bash
curl -X GET \
    -G "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET register`


<!-- END_ff38dfb1bd1bb7e1aa24b4e1792a9768 -->

<!-- START_d7aad7b5ac127700500280d511a3db01 -->
## Handle a registration request for the application.

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST register`


<!-- END_d7aad7b5ac127700500280d511a3db01 -->

<!-- START_d72797bae6d0b1f3a341ebb1f8900441 -->
## Display the form to request a password reset link.

> Example request:

```bash
curl -X GET \
    -G "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/reset" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/reset"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET password/reset`


<!-- END_d72797bae6d0b1f3a341ebb1f8900441 -->

<!-- START_feb40f06a93c80d742181b6ffb6b734e -->
## Send a reset link to the given user.

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/email" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/email"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST password/email`


<!-- END_feb40f06a93c80d742181b6ffb6b734e -->

<!-- START_e1605a6e5ceee9d1aeb7729216635fd7 -->
## Display the password reset view for the given token.

If no token is present, display the link request form.

> Example request:

```bash
curl -X GET \
    -G "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/reset/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/reset/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
null
```

### HTTP Request
`GET password/reset/{token}`


<!-- END_e1605a6e5ceee9d1aeb7729216635fd7 -->

<!-- START_cafb407b7a846b31491f97719bb15aef -->
## Reset the given user&#039;s password.

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/reset" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/reset"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST password/reset`


<!-- END_cafb407b7a846b31491f97719bb15aef -->

<!-- START_b77aedc454e9471a35dcb175278ec997 -->
## Display the password confirmation view.

> Example request:

```bash
curl -X GET \
    -G "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/confirm" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/confirm"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET password/confirm`


<!-- END_b77aedc454e9471a35dcb175278ec997 -->

<!-- START_54462d3613f2262e741142161c0e6fea -->
## Confirm the given user&#039;s password.

> Example request:

```bash
curl -X POST \
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/confirm" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://bqq5qkyokw.5crm.ru/Laravel-SSR-project/public/password/confirm"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST password/confirm`


<!-- END_54462d3613f2262e741142161c0e6fea -->


