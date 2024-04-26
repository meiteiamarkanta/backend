# Database Models Documentation

## User

The `User` model represents a user in the system.

### Attributes
- `id`: The unique identifier for the user.
- `name`: The name of the user.
- `email`: The email address of the user.
- `created_at`: The timestamp when the user was created.
- `updated_at`: The timestamp when the user was last updated.
- `deleted_at`: Soft delete timestamp.

### Relationships
- `courses()`: One-to-many relationship with `Course` model. A user can have many courses.
- `sections()`: One-to-many relationship with `CourseSection` model. A user can have many course sections.
- `resources()`: One-to-many relationship with `CourseSectionResource` model. A user can have many course resources.
- `contents()`: One-to-many relationship with `CourseSectionResourceContent` model. A user can have many course resource contents.
- `tags()`: One-to-many relationship with `Tag` model. A user can have many tags.

---

## Course

The `Course` model represents a course in the system.

### Attributes
- `id`: The unique identifier for the course.
- `title`: The title of the course.
- `description`: The description of the course.
- `created_at`: The timestamp when the course was created.
- `updated_at`: The timestamp when the course was last updated.
- `deleted_at`: Soft delete timestamp.

### Relationships
- `user()`: Belongs to relationship with `User` model. A course belongs to a user.
- `sections()`: One-to-many relationship with `CourseSection` model. A course can have many sections.
- `courseTags()`: One-to-many relationship with `CourseTag` model. A course can have many tags.

---

## CourseSection

The `CourseSection` model represents a section within a course.

### Attributes
- `id`: The unique identifier for the section.
- `title`: The title of the section.
- `course_id`: The foreign key referencing the `Course` model.
- `created_at`: The timestamp when the section was created.
- `updated_at`: The timestamp when the section was last updated.
- `deleted_at`: Soft delete timestamp.

### Relationships
- `user()`: Belongs to relationship with `User` model. A section belongs to a user.
- `course()`: Belongs to relationship with `Course` model. A section belongs to a course.
- `contents()`: One-to-many relationship with `CourseSectionResourceContent` model. A section can have many contents.

---

## CourseSectionResource

The `CourseSectionResource` model represents a resource within a course section.

### Attributes
- `id`: The unique identifier for the resource.
- `title`: The title of the resource.
- `section_id`: The foreign key referencing the `CourseSection` model.
- `created_at`: The timestamp when the resource was created.
- `updated_at`: The timestamp when the resource was last updated.
- `deleted_at`: Soft delete timestamp.

### Relationships
- `user()`: Belongs to relationship with `User` model. A resource belongs to a user.
- `contents()`: One-to-many relationship with `CourseSectionResourceContent` model. A resource can have many contents.

---

## CourseSectionResourceContent

The `CourseSectionResourceContent` model represents the content of a resource within a course section.

### Attributes
- `id`: The unique identifier for the content.
- `title`: The title of the content.
- `section_id`: The foreign key referencing the `CourseSection` model.
- `resource_id`: The foreign key referencing the `CourseSectionResource` model.
- `created_at`: The timestamp when the content was created.
- `updated_at`: The timestamp when the content was last updated.
- `deleted_at`: Soft delete timestamp.

### Relationships
- `user()`: Belongs to relationship with `User` model. A content belongs to a user.
- `section()`: Belongs to relationship with `CourseSection` model. A content belongs to a section.
- `resource()`: Belongs to relationship with `CourseSectionResource` model. A content belongs to a resource.

---

## Tag

The `Tag` model represents a tag that can be associated with various models in the system.

### Attributes
- `id`: The unique identifier for the tag.
- `name`: The name of the tag.
- `created_at`: The timestamp when the tag was created.
- `updated_at`: The timestamp when the tag was last updated.
- `deleted_at`: Soft delete timestamp.

### Relationships
- `user()`: Belongs to relationship with `User` model. A tag belongs to a user.
- `courseTags()`: One-to-many relationship with `CourseTag` model. A tag can be associated with many courses.

---