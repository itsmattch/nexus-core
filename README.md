# About Nexus

Nexus is a robust, flexible library designed to simplify and streamline the
process of integrating systems. With Nexus, you can seamlessly translate raw
information from remote or local streams into entities or collections, providing
an elegant solution to manage your data flow and interactions between disparate
systems.

# Alpha Development Stage

Please note that Nexus is currently in its Alpha stage of development. This
means that it's under constant evolution and improvement. You're welcome to
explore its potential and offer any feedback that might help to enhance the
library.

## To Do Checklist
- [ ] Streams - encapsulate entry points to resources
    - [x] [Addresses](https://nexus.itsmattch.com/streams/addresses) - Parametrize the endpoints
    - [ ] Engines - Encapsulate connection logic and access resources
    - [ ] Reader - Turn raw responses into resources
- [ ] Repository - Entities discovery
    - [ ] Implement logic for discovering new entities
    - [ ] Enable discovery of entity deletion based on repository config
- [ ] Assemblers - Entities information scrappers
    - [ ] Implement logic for merging information scattered across resources
- [ ] Emitters - Turn states into events
- [ ] ...

# License

Nexus is open-sourced software licensed under
the [MIT license](https://opensource.org/license/mit/).