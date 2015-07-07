# *Two Stroke*
Two-stroke is a PHP micro-framework aiming at mapping *Business Requirements* directly to *Code Engines*. It helps by regulating class naming/loading and behaviour/concern separation.
The name comes from its design being loosely related to a two stroke engine.

## Project aim
The aim of *Two Stroke* is to create a way of satisfying user requests with modular, single-purpose and re-usable Engines.

###What is an Engine
An Engine is composed of two parts:

  * An Inlet that processes a request
  * An Outlet that outputs a response

I generally don't draw similarities. However, the paradigms of Inlet and Outlet could be loosely compared to a **Model Function Invocation** (Inlet) and View (Outlet). The Controller would be the **Core** which performs orchestration.

### Modular
The Engines of an application are defined in such a way that it would almost be unnatural to write spaghetti code.

**Example:**
A dynamic-page rendering component will have an Inlet that, based on the page-name parameter, loads the content from a file and an Outlet that displays it to the users.

### Single Purpose
Each Engine has a pre-defined specification that will only satisfy one requirement.

**Example:**
>Business Requirement 12XYD: The user must be able to enter "registration data" in a web form (See "registration data" definition in doc. 143AA).

>Developer Analysis: A Registration-Form Engine must have an Inlet that defines the "registration data" to gather and an Outlet that renders the form to the end-user.

### Reusable
Engines can be easily copied from one web-application to another speeding up development.

**Example:**
A Login-Form Engine could be transported from App-X to App-Y. The processing of the form could be different between the two apps so they would have different Login-Form processing Engines. However, the form could have the same characteristics.
