# Readme

## Currency Convertr
A simple but adaptable currency conversion application

<img width="100%" alt="screencapture-localhost-8000-2026-02-13-12_22_45" src="https://github.com/user-attachments/assets/87ba2665-090d-455e-af6a-d903cc46d087" />
<img width="100%" alt="screencapture-localhost-8000-2026-02-13-12_36_05" src="https://github.com/user-attachments/assets/8c418245-a623-445c-aa3c-f819ace886bd" />


## Build

### Starter Kit

This was built on the NuxtUI/Laravel starter kit which can be found at [jkque/laravel-nuxt-ui-starter-kit](https://github.com/jkque/laravel-nuxt-ui-starter-kit) for ease of building out a pleasant, user friendly UI quickly.  I stripped it down to remove a lot of the bits and bobs which I wasn't going to use (auth, etc.) and removed the templated frontend.

### Premise

This is an application which on the face of it is very simple, yet has the potential to grow with the business constraints of the company who own it: The API which you use for the currency conversions is easily interchangeable. To use an API other than the configured [Fixer API](https://fixer.io/), create another `CurrencyConversionDriver` compliant "driver" and set your preffered currency conversion driver in your `.env` file as you would with database driver, cache driver, session driver etc.

### UI

Feedback to the user is important. This application uses both client-side and server-side validation, and is configured to display any non-form-validaton error messages to the user in neat little toasts at the bottom of the screen.

<img width="100%" alt="server-side validation" src="https://github.com/user-attachments/assets/0fd7dccb-2104-4c2f-b29c-c89290a39a93" />
<img width="100%" alt="client-side validation" src="https://github.com/user-attachments/assets/3cb6a2b2-e92c-47a0-bb49-6e1530385703" />
<img width="100%" alt="error messages" src="https://github.com/user-attachments/assets/3bd51ae0-f7b9-485e-ae7c-65612926df10" />

## Considerations

### Cacheing API results

I'm conscious that API usage can be expensive, and if there's no update on the part of the API that we're consuming for a minimum of 10 minutes, then there's no need to re-fetch the same data and use up our request allowance. For that reason, I'm cacheing the response of the exchange rate APIs for a duration configurable in the project's configuration file `currencies.php`. The tradeoff here is that we don't provide our users with bang up-to-date exchange rates, but we significantly speed up requests on our end and can therefore handle a greater volume of requests to our service.

### Expandability

I wanted to ensure that we can deliver a robust service to users, and one of the ways that I hope to achieve that is by providing different options when it comes to the exchange rate serivce that we use behind the scenes. For instance if one service is found to be better for our business purposes, it should be easy to create a driver for that API and make the switch to that new service.

### To Do

#### DTOs

It'd be nice to have had more time to formalise our API's response rather than just passing back a cobbled-together array.

#### Single Source of Truth

It'd have been nice to spend a bit of time crafting a way for the front and the backend to draw the supported currencies from a single list, rather than separating them out into separate lists for the front and backend like I did.

#### F/E Dependencies

I'm aware that there are some f/e dependency issues which need resolving.



