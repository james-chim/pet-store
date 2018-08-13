<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Category
 *
 */
	class Category extends \Eloquent {}
}

namespace App{
/**
 * App\Pet
 *
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 */
	class Pet extends \Eloquent {}
}

namespace App{
/**
 * App\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Pet[] $pets
 */
	class Tag extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

