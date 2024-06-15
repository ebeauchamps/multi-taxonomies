# Multi-Taxonomies

Multi-Taxonomies - Statamic Addon

> The Multi-Taxonomies addon for Statamic streamlines the configuration of data relationships using taxonomies. This means that the options displayed in the second selector dynamically adjust based on the choice made in the first selector.
> This enhances user experience by providing an intuitive and personalized selection process, allowing users to focus on and choose only the relevant options based on their initial selection.
> It's essential to emphasize that taxonomies must be interconnected in a one-to-many relationship through dependent fields utilizing a foreign key in the taxonomy that acts as the dependent one.


## Key Features:

> Simplifies configuration of data relationships through taxonomies.
> Dynamically adjusts the options in the second selector based on the choice in the first selector.
> Enhances user experience by providing a personalized selection process.



## How to Install
## Installation:
Run the following command from your project root:

```  bash 

composer require ebeauchamps/multi-taxonomies

```


## Using the Addon:
To make the most of the Multi-Taxonomies addon, follow these steps:
1. Create two taxonomies that will be related in a one-to-many relationship.
2. Ensure that the dependent taxonomy has a field with a foreign key to link the data to the first taxonomy.
This addon is specifically designed to assist in retrieving or populating dependent select fields within the content management control panel in Statamic. Make your data relationships seamless and enhance the user's ability to make informed and relevant selections.


## How to Use


1. Set Up Taxonomies:
   - Create two taxonomies establishing a one-to-many relationship.
   - Ensure the dependent taxonomy has a field with a foreign key linking it to the first taxonomy.
2. Create Field Type:
   - Within the content you intend to use, create the field type.
   - Choose the "Multi Taxonomies" field type in the Special section when configuring your content blueprints.
3. Configure Resource:
   - In the resource configuration section, select "taxonomy" as the resource origin.
   - This enables the configuration section for the two taxonomies that will populate the two selects.
4. Configuration of the First Taxonomy:
   - Three configuration fields are available:
        "First Taxonomy": Choose the taxonomy populating the first select.
        "Primary Key": Specify the primary key column within the first taxonomy.
        "Text Field": Specify the column containing visible text for the end user.
5. Configuration of the Second Taxonomy:
    - In this section, configure information for the second taxonomy with four fields:
        "Second Taxonomy": Choose the source of data for the second select (dependent one).
        "Foreign Key": Specify the foreign key in the second taxonomy establishing the one-to-many relationship with the first taxonomy.
        "Primary Key of the Second Taxonomy": Specify the primary key of the second taxonomy.
        "Text Field": Enter the name of the column containing text or labels for the second select.
        Follow these steps to seamlessly integrate and configure the Multi-Taxonomies addon, enhancing the user's ability to make informed and relevant selections based on the dynamic relationships between the two taxonomies.


