# Facial Comparison Api Server

[![Pre-Release version](https://img.shields.io/github/v/release/amir-shamsi/facial-comparison-api-server?style=flat-square)](https://github.com/Amir-Shamsi/facial-comparison-api-server)
[![symfony version](https://img.shields.io/badge/symfony-%5E5.3-blue?style=flat-square)](https://symfony.com/)
[![APM Licence](https://img.shields.io/badge/licence-CC0-geen?style=flat-square)](LICENSE)
[![Follow me](https://img.shields.io/github/followers/amir-shamsi?label=follow%20me&style=social)](https://github.com/amir-shamsi)

[![ForTheBadge built-with-love](http://ForTheBadge.com/images/badges/built-with-love.svg)](https://github.com/Amir-Shamsi)

## An API for your dream login form

This is an api which has been written on symfony framework which is one of the gratest and most powerful framework since 2005.
it's not up yet but when it uploads on server some strict api_tokens will be added.
<br>


## Features

- Fast execution ⚡
- Compare your face images by posting urls ✅
- Post original images if you don't have urls 👥
- Respond clearly and fast (cuz time is impotatnt) 🕘
- Get useful information about the comparison performed (presentage & ...) 〽
- Get clear errors if there is one with solution ⚠

## Guide (how it works)
- Set Content-Type to application/json in header if you want to post images by url

  ![fscs-0](/public/assets/img/fscs-0.png)
  
- If you have image urls For body we need a `sourceFace` and `targetFace` so it must look like this:
  ```
  {
    "sourceFace": "https://amirshamsi.ir/u/59437623?v=4/amir-1.jpg",
    "targetFace": "https://amirshamsi.ir/u/59437623?v=4/amir-1.jpg"
  }
  ```
  
  ![fscs-4](/public/assets/img/fscs-4.png)
  
- If you don't have image urls and you want send images For body  `sourceFace` and `targetFace` with type *File* must be defined, like this:

  ![fscs-4](/public/assets/img/fscs-3.png)
  
- The respond an result will looks like this
  - Body:
  
    ![fscs-3](/public/assets/img/fscs-3.png)
    
  - Header:
  
    ![fscs-1](/public/assets/img/fscs-1.png)

## Limitations
- Image must be under 5MB or you get a validation error from server this limitation is just for getting fast respond for you
- ### solution:
  - you can use [LiipImagineBundle](https://github.com/liip/LiipImagineBundle)

##### Any feedback will be highly appreciable
