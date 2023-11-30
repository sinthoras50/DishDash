import axios from "axios";
import MockAdapter from "axios-mock-adapter";
import activityLogs from "./activityLogs.json";
import donations from "./donations.json";
import events from "./events.json";
import notifications from "./notifications.json";
import profileInfo from "./profileInfo.json";
import users from "./users.json";

const now = Date.now();

function generateId() {
  return (Math.floor(Math.random() * 10000) + 1).toString();
}

// This sets the mock adapter on the default instance
let mock = new MockAdapter(axios, { delayResponse: 2000 });

// Landing
mock.onPost("/api/message").reply(200);

// Activity
mock.onGet("/api/activity-logs").reply(200, activityLogs);

// Auth
mock.onPut("/api/password").reply(({ data }) => [200, data]);
mock.onPost("/api/forgot-password").reply((config) => {
  const { email } = JSON.parse(config.data);

  const user = users.find((user) => user.email === email);

  if (user) {
    return [200];
  } else {
    return [400];
  }
});
mock.onPost("/api/forgot-password-submit").reply(400);
mock.onPost("/api/login").reply((config) => {
  const { email, password } = JSON.parse(config.data);

  const user = users.find(
    (user) => user.email === email && user.password === password
  );

  if (user) {
    return [200, { token: user.token }];
  } else {
    return [401, { error: "Invalid credentials" }];
  }
});
mock.onPost("/api/logout").reply(200);
mock.onPost("/api/register").reply(201);
mock.onGet("/api/user-info").reply((config) => {
  const { key } = config.params;
  const user = users.find((user) => user.token === key);

  if (key && user) {
    return [200, user];
  } else {
    return [404, { error: "User not found" }];
  }
});

// Events
mock.onDelete("/api/events").reply(({ data }) => [200, data]);
mock.onGet("/api/events").reply(
  200,
  events.map((e) => ({ ...e, start: now, end: now }))
);
mock
  .onPost("/api/events")
  .reply(({ data }) => [201, { ...JSON.parse(data), id: generateId() }]);
mock.onPut("/api/events").reply(({ data }) => [200, data]);

// Notifications
mock.onGet("/api/notifications").reply(200, notifications);

// Profile
mock.onGet("/api/profile-info").reply(200, profileInfo);
mock.onPut("/api/profile-info").reply(({ data }) => [200, data]);

// Users
mock.onDelete("/api/donations").reply(({ data }) => [200, data]);
mock.onGet("/api/donations").reply(200, donations);
mock
  .onPost("/api/donations")
  .reply(({ data }) => [201, { ...JSON.parse(data), id: generateId() }]);
mock.onPut("/api/donations").reply(({ data }) => [200, data]);
