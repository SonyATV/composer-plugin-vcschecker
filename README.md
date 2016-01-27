VCS URL Checker plug-in for Composer
====================================

This Composer plug-in checks your VCS definitions for file:/// URLs and errors out if it finds any.

##### Installation

composer global require sonyatv/composer-plugin-vcschecker

##### Usage

composer status

##### Miscellaneous

Valid VCS URLs for the purpose of this plug-in do not contain file:/// as the protocol.

Output of composer status will indicate if the VCS section of composer.json is valid or not, and the exit code will be 0 if the VCS section is valid, and 1 if it is not.
