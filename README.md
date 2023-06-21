# About Nexus

Nexus is a robust, flexible library designed to simplify and streamline the
process of integrating systems. With Nexus, you can seamlessly translate raw
information from remote or local streams into entities or collections, providing
an elegant solution to manage your data flow and interactions between disparate
systems.

# Discovery Development Stage

Please note that Nexus is currently in the Discovery stage of development. This
implies that the fundamental functionalities of the app are still in the process
of ideation and refinement. Given the nature of this stage, significant
alterations to large sections of the codebase may occur frequently.

## To Do Checklist

- [x] Streams - encapsulate entry points to resources
    - [x] [Addresses](https://nexus.itsmattch.com/streams/addresses) -
      Parametrize the endpoints
    - [x] Engines - Encapsulate connection logic and access resources
    - [x] Reader - Turn raw responses into resources
- [x] Repository - Entities discovery
    - [x] Implement logic for discovering new entities
    - [ ] Enable discovery of entity deletion based on repository config
- [x] Assemblers - Entities information scrappers
    - [ ] Implement logic for merging information scattered across resources
- [ ] Emitters - Turn states into events
- [ ] ...

# License

Nexus is open-sourced software licensed under
the [MIT license](https://opensource.org/license/mit/).