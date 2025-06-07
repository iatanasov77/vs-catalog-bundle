2.4.1	|	Release date: **07.06.2025**
============================================
* New Features:
  - Remove All Doctrine Migrations.
  - Summerize All Old Doctrine Migrations.


2.4.0	|	Release date: **06.06.2025**
============================================
* New Features:
  - Fix some Deprecations.
  - Remove 'cascade-merge' option Doctrine Mapping Files.
  - Remove Annotations from All Model Traits.
  - Update Payment Bundle Version Constraint.


2.3.6	|	Release date: **13.05.2025**
============================================
* New Features:
  - Set in Developement Mode.
  - Return Payment Bundle to Production Mode.


2.3.5	|	Release date: **07.05.2025**
============================================
* New Features:
  - Add a Repository Method to Find PricingPlanSubscriptions for Gateway Attribute.


2.3.4	|	Release date: **07.05.2025**
============================================
* New Features:
  - Add a Flag if Recurring Payment is Cancelled into PricingPlanSubscription Model.


2.3.3	|	Release date: **06.05.2025**
============================================
* Bug-Fixes and Improvements:
  - Set Developement Mode for Payment Bundle.
  - Add a Doctrine Migration.
  - Move Shopping Cart Routes into Payment Bundle.
  - Fix PricingPlanCheckoutController to Set Recurring Payments when Recurring Payment is Checked.
  - Fix PricingPlan Checkout.
  - Add Another Option for Gateway Attributes for Pricing Plan Form.
  - Update Some Routes IDs.


2.3.2	|	Release date: **01.05.2025**
============================================
* New Features and Improvements:
  - Improve Pricing Plans Routes.


2.3.1	|	Release date: **30.04.2025**
============================================
* New Features and Improvements:
  - Remove '/payment' Prefix from All Routes.


2.3.0	|	Release date: **29.04.2025**
============================================
* New Features:
  - Add Pricing Plan Attribute Field into the Form.
  - Move Some Pricing Plan Resource Translations From Payment Bundle.


2.2.3	|	Release date: **31.03.2025**
============================================
* Bug-Fixes:
  - Fix PricingPlanSubscriptionsSubscriber to NOT SET Subscription Expires Date Before The Payment Finished Successfull.


2.2.2	|	Release date: **31.03.2025**
============================================
* Bug-Fixes:
  - Fix PricingPlanSubscriptionsSubscriber to NOT SET Subscription Expires Date Before The Payment Finished Successfull.


2.2.1	|	Release date: **31.03.2025**
============================================
* New Features:
  - Improve CreateNewUserSubscriptionEvent and Subscriber that subscribed to this event.


2.2.0	|	Release date: **30.03.2025**
============================================
* New Features and Improvements:
  - Add a Doctrine Migration.
  - Add A Field into PricingPlan Model, that to be pass to Payment Gateways as Description.
  - Improve Some Doctrine Mappings.
  - Add a Method in PricingPlanCategory Model to Get Only Enabled Plans.
  - Improve a PricingPlan Repository Method.
  - Create Just One Pricing Plan Subscriptions for User for a Pricing Plan.
  - Remove Active Flag on PricingPlanSubscription Model.
  - Add Some Translations.


2.1.1	|	Release date: **15.03.2025**
============================================
* Bug-Fixes:
  - Fix Some Deprecation.


2.1.0	|	Release date: **15.03.2025**
============================================
* New Features , Fixes and Updates:
  - Update Composer Requirements.
  - Fix Doctrine Mapping.
  - Load CkEditor 5 in Pages that use wysywyg editors.
  - Update Payment Bundle Version Constraint.


2.0.3	|	Release date: **03.03.2025**
============================================
* Bug-Fixes:
  - Fix an Updated Service ID in Vankosoft Application Core.


2.0.2	|	Release date: **14.01.2025**
============================================
* New Features:
  - Separate Product Filter Form View in a Different File.
  - Create Custom Route to Get Product Form on Loacale DropDown Change.


2.0.1	|	Release date: **11.01.2025**
============================================
* New Features and Improvements:
  - Update Package Title and Description.
  - Create Product Filter By Category to Work.


2.0.0	|	Release date: **06.01.2025**
============================================
* New Features and Improvements:
  - Improve Using FOS CkEditor.
  - Add Conditional CkEditor Version to Use in Forms.
  - Improve ProductCategory Model.
  - Combine Doctrine Migrations.
* Bug-Fixes:
  - Fix a Product Model Doctrine Mapping.


1.4.0	|	Release date: **21.12.2024**
============================================
* New Features:
  - Set Payment Bundlein Develepement.
  - Update Vankosoft Payment Bundle Requirement Version.


1.3.15	|	Release date: **25.07.2024**
============================================
* Bug-Fixes:
  - Fix Fixtures ProductsExampleFactory .


1.3.14	|	Release date: **22.07.2024**
============================================
* New Features and Improvements:
  - Improve Widgets Fixtures Configs.


1.3.13	|	Release date: **18.07.2024**
============================================
* Bug-Fixes:
  - Fix PricingPlanCategoryInterface.


1.3.12	|	Release date: **28.06.2024**
============================================
* New Features:
  - Improve Product Resource Model and Repository.


1.3.11	|	Release date: **28.06.2024**
============================================
* New Features:
  - Change ORM Type of ProductBase Resource.


1.3.10	|	Release date: **28.06.2024**
============================================
* New Features:
  - Improve ProductForm.


1.3.9	|	Release date: **27.06.2024**
============================================
* Bug-Fixes:
  - Fix a Twig Template.


1.3.8	|	Release date: **24.06.2024**
============================================
* Bug-Fixes and Improvements:
  - Improve Some Form Types.


1.3.7	|	Release date: **23.06.2024**
============================================
* New Features and Improvements:
  - Improve Products Index Page.


1.3.6	|	Release date: **23.06.2024**
============================================
* New Features:
  - Improve Products Index Page.


1.3.5	|	Release date: **23.06.2024**
============================================
* New Features and Improvements:
  - Add Doctrine Fixture for Application Locale Widget.
  - Improve Products Index Page.


1.3.4	|	Release date: **19.06.2024**
============================================
* Bug-Fixes:
  - Remove Using ENV Variables in Sample Data Fixtures.


1.3.3	|	Release date: **04.06.2024**
============================================
* Bug-Fixes:
  - Fixing Some Resource Mappings Errors.


1.3.2	|	Release date: **21.05.2024**
============================================
* New Features:
  - Improve PricingPlansCheckoutController .


1.3.1	|	Release date: **16.05.2024**
============================================
* Bug-Fixes:
  - Fix Twig Templates Namespaces.


1.3.0	|	Release date: **14.05.2024**
============================================
* Bug-Fixes:
  - Fix Doctrine Migrations.


1.2.8	|	Release date: **12.05.2024**
============================================
* New Features:
  - Use Twig Macros to Display Form Errors.
  - Some VS Application Bundle Provided Traits Namespace was Changed.


1.2.7	|	Release date: **10.05.2024**
============================================
* New Features:
  - Add Some Translations.


1.2.6	|	Release date: **10.05.2024**
============================================
* Bug-Fixes and Improvements:
  - Fix Cascade Operations of PayableObjectAwareEntity .
  - Update PaymentBundle Required Version.
  - Prevent Creation of Many Subscription For a Service By an User.
  - Add Debugging Feature in PricingPlanSubscriptionsSubscriber .
  - Fix Changing Subscription Expires Date on New Payment Created.


1.2.5	|	Release date: **09.05.2024**
============================================
* New Features and Improvements:
  - Create Product Review Repository.
  - Add Some Traits for Discover Models.
  - Create 'Select Payment Method Template' for Non Ajax Requests.
  - Improve Pricing Plan Checkout.


1.2.4	|	Release date: **01.05.2024**
============================================
* New Features:
  - Add Reaviewable Subjects Average Rating Updater.


1.2.3	|	Release date: **24.04.2024**
============================================
* Bug-Fixes and Improvements:
  - Update All Forms about New Symfony Interfaces.
  - Create Model ReviewableTrait .
  - Fix PayableObjectAwareEntity .


1.2.2	|	Release date: **15.03.2024**
============================================
* New Features:
  - Improve Model Traiits Attribute ORM Mappings.


1.2.1	|	Release date: **08.03.2024**
============================================
* New Features and Improvements:
  - Add Some Improvements.


1.2.0	|	Release date: **22.02.2024**
============================================
* New Features:
  - Add PaymentBundle in Develop Mode.
  - Remove Relation Between PricingPlan and Coupon .
  - Add Promotions For Catalog.
  - Update PatbleObjectAwareTrait .
  - Add Some Doctrine Migrations.
  - Add Fixtures for Customer Groups
  - Add a Promotion Rule Checker.
* Bug-Fixes:
  - Fix PricingPlanSubscriptionsSubscriber .
  - Fix PricingPlanSubscription Model and Mapping.
  - Fix as Service Definition.
  - Fix Displaying Form Errors.


1.1.2	|	Release date: **13.02.2024**
============================================
* Bug-Fixes and Improvements:
  - Fix Payment Routes.
  - Remove PaidServiceCategory Resource From Fixtures.
  - Add a Doctrine Migrations.


1.1.1	|	Release date: **12.02.2024**
============================================
* New Features , Fixes and Improvements:
  - Add ServiceAssociation Resource and Remove it Later.
  - Fix a Doctrine Mapping.
  - Create a ProductBase Model to use For Other Custom Products.
  - Fix Some Model Doctrine Mappings.
  - Fix PricingPlanSubscription Model.
  - Remove ContentService Model. Use ProductBase Model With Needed Traits.
  - Add a Doctrine Migration.


1.1.0	|	Release date: **10.02.2024**
============================================
* New Features and Improvemets:
  - Improve Product Edit File Inputs.


1.0.7	|	Release date: **10.02.2024**
============================================
* New Features:
  - Improve Product Pictures Model and Add Product Files Model.
  - Add a Doctrine Migration
  - Improve Product Edit View.
  - Update Product Fixtures About New Features in Product Model.


1.0.6	|	Release date: **07.02.2024**
============================================
* New Features and Improvements:
  - Display Uncategorized Products.


1.0.5	|	Release date: **07.02.2024**
============================================
* Bug-Fixes:
  - Fix Products Index Page Template.
  - Imptove Nested Accordion View in Products Listing Page.


1.0.4	|	Release date: **07.02.2024**
============================================
* Bug-Fixes:
  - Add Templates Variable 'items' where is Needed and get Translations from Not Paginated resources where Is Neeed.


1.0.3	|	Release date: **06.02.2024**
============================================
* Bug-Fixes:
  - Fix Catalog Application Fixtures.


1.0.2	|	Release date: **05.02.2024**
============================================
* New Features, Fixes and Improvements:
  - Create a CatalogController to Use in Front Applications.
  - Update Catalog Controller
  - Update Catalog Routes.
  - Add a Catalog Fix.
  - Add Descriptions into Product and PricingPlan Categories.
  - Improve Sample Data Fixtures.
  - Improve TaxonDescendentTrait .
  - Update Sample Data Fixtures.
  - Add Fixtures for Application Configuration.
  - Fix Product Categories Fixtures Definitions.
  - Add a Config Parameter For Latest Products Limit.
  - Improve Data Fixtures.
  - More Improvements on Catalog Pages.
  - Add More Fields into Product Model.
  - Add a Doctrine Migration.
  - Create New Product Form Fields.
  - Use tagify in ProductForm
  - Display Featured Products in Home Page.
  - Fix AssociationStrategyRepositoryTrait .


1.0.1	|	Release date: **01.02.2024**
============================================
* New Features:
  - Load Assets in Association Types Index Page.
  - Move AdminPanel Default Theme User Catalog Pages Assets From Application Bundle.
  - Update Payment Bundle Version Constraint.
  - Add New Fixtures and Fixtures Refactoring.
* Bug-Fixes:
  - Some Fix.
  - Fix ProductsExampleFactory .
  - Fix Pricing Plans Fixture Classes and Definitions.


1.0.0	|	Release date: **30.01.2024**
============================================
* New Features, Fixes and Improvements:
  - Create Payable Object Associations Types.
  - Add a Doctrine Migration.
  - Make Product Model Timestamppable.
  - Add AssociationTypeForm Service.
  - Add Some Translations
  - Add Some Fixes.
  - Create Association Strategy Component and Use It.
  - Improve Index Twig Templates.
  - Fix ProductRepository .
  - Add Some Translations.
  - Add Form Types for Product Associations.
  - Improve Products Index View.
  - Fix ProductCategoryForm .
  - Fix Path Routes in Views.
  - Fix and Improve Product Form.
  - Fix and Improve ProductAssociations Form.
  - Fix and Improve PricingPlanCategory Form.
  - Create ProductExtController .
  - Improve ProductForm.
  - Create Handling Product Associations Form.
  - Remove Uneeded Form Type.
  - Remove Required Option From Product Associations.
  - Update Products Views.
  - Fix ProductsToProductAssociationsTransformer .
  - Improve ProductAssociationsType
  - Remove Product Associations Form From Create Neew Product Form.


0.1.12	|	Release date: **25.01.2024**
============================================
* New Features:
  - Add First Doctrine Migration.


0.1.11	|	Release date: **25.01.2024**
============================================
* New Features and Improvements:
  - Fix a Table Name in Many to Many ORM Mapping.


0.1.10	|	Release date: **25.01.2024**
============================================
* Bug-Fixes:
  - Some Stupid Fix.


0.1.9	|	Release date: **25.01.2024**
============================================
* New Features:
  - Create Traits and Interfaces for Payment Bundle Relations.
* Bug-Fixes:
  - Fix Wrong Namespaces From Payment Bundle.


0.1.8	|	Release date: **25.01.2024**
============================================
* New Features:
  - Add Some Model Trait.


0.1.7	|	Release date: **24.01.2024**
============================================
* New Features:
  - Add Subscriptions Event Subscriber from PaymentBundle.


0.1.6	|	Release date: **24.01.2024**
============================================
* Bug-Fixes:
  - Add Some Fixes.


0.1.5	|	Release date: **24.01.2024**
============================================
* Bug-Fixes:
  - Add Some Fixes.


0.1.4	|	Release date: **24.01.2024**
============================================
* Bug-Fixes:
  - Add Some Fixes.


0.1.3	|	Release date: **24.01.2024**
============================================
* Bug-Fixes:
  - Fix Controller Services.


0.1.2	|	Release date: **24.01.2024**
============================================
* New Features:
  - Change Payment Bundle Version.
* Bug-Fixes:
  - Add Some Fixes.


0.1.1	|	Release date: **24.01.2024**
============================================
* New Features:
  - Add Some Documents.
  - Move Catalog Models From Payment Bundle Here.


0.1.0	|	Release date: **22.01.2024**
============================================
* New Features:
  - Initial commit
  - First Commit.


