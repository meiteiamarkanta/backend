<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Str;

class AuthServices
{
    /**
     * Generate a unique username based on the user's first name and last name.
     *
     * This function combines the first name and last name in various ways to create
     * a base username. It then adds a random number to the base username to ensure
     * uniqueness. If none of the generated usernames are unique, a UUID is used as a fallback.
     *
     * @param string $firstName The user's first name.
     * @param string $lastName The user's last name.
     * @return string The unique username.
     */
    function generateUniqueUsername($firstName, $lastName)
    {
        $randomNumber = mt_rand(1, 999);  // Generate a random number between 1 and 999

        $baseUsernameOptions = [
            Str::slug($firstName . '.' . $lastName),  // Combine first name and last name with dot
            Str::slug($firstName) . '.' . Str::random(2),  // First name with random characters
            Str::slug($lastName) . '.' . Str::random(2),  // Last name with random characters
            Str::slug($firstName) . '_' . Str::slug($lastName),  // Combine first name and last name with underscore
        ];

        // Shuffle the base username options to randomize the order
        shuffle($baseUsernameOptions);

        foreach ($baseUsernameOptions as $baseUsername) {
            $username = $baseUsername;

            // Add the same random number to the username
            $username .= '.' . $randomNumber;

            // Check if the username already exists
            if (!User::where('username', $username)->exists()) {
                return $username;
            }
        }

        // Fallback to UUID if all other options fail
        return $firstName . '.' . $lastName . Str::uuid();
    }
}
