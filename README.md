## Prerequisites
* PHP 7.1 (just because nullable return types are used in few places)
* MySQL Server 5.5 and above
* Composer

## Installation

1. Checkout repository into folder
2. Go to the folder and run `composer install`
3. Set values for db name and credentials
4. Run `./bin/console doctrine:migrations:migrate` command.
5. Run `./bin/console server:run` for built-in webserver

## Usage

Initially there is no any data in the system. For the moment, we don't have special command to create the characters. But for testing, you can run `./bin/console doctrine:fixtures:load` and it will load the fixtures.

Therefore we could use the API even on empty db. It has swagger-styled sandbox on `/api/v1/docs` so you can use it.

Note there is no any authentication.

All POST request require send entity id (UUID4) explicitly. Just to avoid problems with multiple resources creation and so on. It means every request will have it's own unique id.
 
1. For character creating, just send POST equest like `{"id": "4a7fe76a-e99b-4149-acc6-8a0fe7fcfcb0", "prototype": "warrior"}` to `/api/v1/characters`. If the character has been created before, or the parameters wrong you will get 400 response. Note there are no validation yet for invalid prototype - so you'll get 500 error if try to use invalid character prototype (wanted to write custom validator for that).
2. For getting character list send GET request to `/api/v1/characters`
3. For exploring the world send GET request like `/api/v1/characters/968ad663-4e4d-4719-8fc7-af72ff931909/tiles`
4. For moving to tile send request like like `{"id":"127399fe-f693-4c82-a503-d63545092395","tile":"4f921f6e-19d8-4f97-bd39-bf0c3c06037a"}` to URL like `/api/v1/characters/968ad663-4e4d-4719-8fc7-af72ff931909/turns`. If the tile contains enemy character, the battle will happen. If your character will lose the battle, his health will become 0, and he will disappear (from character list) - like game over. Otherwise, the character will receive some experience. There is no validation for movement - so possible to move to any tile (but if the tile belongs to another world an error will occured).
5. Because of character always keep its actual state, there is no options to save and restore the game. The game context will be saved and loaded every time when we perform the turn. 

Note that basically it works, but obviously can be improved.

## How it works
For creation entities `Command` and `Command bus` are used. When user creates the character, command handler fires an event - and new world will be created. After that, new event will be fired - and world will be populated with enemies.
When player performs the turn, and set new position for the character - event for the turn will be fired and event listeners check if there is a battle possibility and so on. After battle, new event fires and player either receives experience or his character's health will be reduced to 0 (after that player can't use the character).

## How it could be configured
All the configuration keeps in `src/AppBundle/Resources/config/services.yml` so you can redefine parameters and so on. 

## How it could be extended
It uses pretty flexible architecture. So, for example, you can add new character prototype easily. Just look at configuration - there is registry with prototypes and compiler pass that can build the registry.

You can easily add new abilities to character. For now, there is only `fighting bonus` ability - but you can add your own.

There is few different strategies - for example, for exploring the world. So new prototype with ability like `spyglass` could be easily added - and it's not a big deal to create new strategy and allow new character to have observing bonus. 

Also strategies are used for fighting - there is strategy for fighting bonus, for experience calculation, and so on.

Also events are used widely - so you can easily add feature like health increasing before (or after) each turn.
  
## Tests
I've covered the API only with few `Behat` tests. Tests are in the `src/AppBundle/Tests` folder.

## Missed stuff
1. Validators. There are few validators, but I'd add validators for movement, and for  
2. Parametrized class aliases (like `app.entity.character`) instead of classes in doctrine mapping. Could be solved easily with dynamic mapping for one2many (one2one and many2one doesn't require any actions excepts configuring doctrine).
3. Some code parts could be improved.
4. There is no unit tests at all.
5. Populating the world implicitly looks weird.
6. Interfaces (or at least aliases) instead of classes in serializer. Could be solved by refactoring existed handler (for entity from UUID deserialization).
7. I did'n write comments, therefore think the variables look pretty clear. But doc comments could be added. 
8. Some code places look coupled a bit. Could be refactored though.
9. One constructor have 6 input variables. OK, other have max 4.
10. Have some doubts regarding instantiating entities with constructors in factories.

## Why I've chosen the Symfony?
Because it's my favorite framework.

## Why I've chosen REST API instead of console app?
I had some doubts, but REST API can be covered with acceptance test much easier than interactive console app. Moreover, it will have simpler structure. But I also did some console apps, you can look at the examples in my github repo.

## Why I use JMSSerializer instead of native Symfony?
Just because it more convenient for that task. 

## Why I don't use abstract classes?
Actually have one in fixtures :)

## Why I don't use API platform?
I didn't want to fight against API platform in this particular project.

## Why there is no any authentication/authorization?
Because it's single-player application. Therefore OAuth2 could be added easily.

## Why do I use annotations in controller?
Mainly for APIDoc. It could be moved into .yaml though.

## Why do I don't use different classes for different types of exception?
Actually I do a bit, but there is no necessity to do it.
 
## Why the project won't be run on Raspberry Pi?!
Actually it will, but swap partition is required.
