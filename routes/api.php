<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::post("/login", [AuthController::class, "login"]);

Route::middleware("auth:api")->group(function () {
    Route::get("/me", [AuthController::class, "me"]);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get("/my-tasks", [TaskController::class, "myTasks"]);
    Route::apiResource("tasks", TaskController::class);
});

Route::middleware(["auth:api", "role:root"])->group(function () {
    Route::apiResource("users", UserController::class);
});
