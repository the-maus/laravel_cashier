> [!NOTE]
>Your [Stripe](https://dashboard.stripe.com/) service and recurring prices must be set on `.env` file with the variables below and your local client must be running if your in sandbox.

```
STRIPE_PRODUCT_ID
STRIPE_MONTHLY_PRICE_ID
STRIPE_YEARLY_PRICE_ID
STRIPE_THREE_YEAR_PRICE_ID
```
>
## Tests

- [x] Non-logged user must be redirected to Login page when accessing default route
- [x] Non-logged user can access Login Page
- [x] Non-logged user can login (redirect to Plans or Dashboard Page)
- [ ] Non-logged user can't access Plans page
- [ ] Non-logged user can't subscribe to plan
- [ ] Non-logged user can't access Subscription Success page
- [ ] Non-logged user can't access Dahsboard
- [ ] Non-logged user can't download invoice
- [ ] Non-logged user can't logout
***
- [ ] Logged (non-subscribed) user must be redirected to Plans page when accessing default route
- [ ] Logged (non-subscribed) user can access Plans page
- [ ] Logged (non-subscribed) user can subscribe to plan
- [ ] Logged (non-subscribed) user can't access Subscription Success page
- [ ] Logged (non-subscribed) user can't access Dashboard
- [ ] Logged (non-subscribed) user can't download invoice
- [ ] Logged user can't access login page
- [ ] Logged user can logout
***
- [ ] Subscribed user must be redirected to Dashboard page when accessing default route
- [ ] Subscribed user can access Subscription Success page
- [ ] Subscribed user can access Dashboard
- [ ] Subscribed user can download invoice
- [ ] Subscribed user can't access Plans page
- [ ] Subscribed user can't subscribe to plan
