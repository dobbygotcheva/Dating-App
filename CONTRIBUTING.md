# Contributing to Mismatch Dating Website

Thank you for your interest in contributing to the Mismatch Dating Website! This document provides guidelines and information for contributors.

## 🤝 How to Contribute

### Reporting Bugs
- Use the GitHub issue tracker
- Include detailed steps to reproduce the bug
- Provide your PHP version and server environment
- Include error messages and logs if applicable

### Suggesting Features
- Open a new issue with the "enhancement" label
- Describe the feature and its benefits
- Consider the impact on existing functionality

### Code Contributions
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 🛠️ Development Setup

### Prerequisites
- PHP 7.4+
- SQLite3 extension
- Git

### Local Development
```bash
# Clone your fork
git clone https://github.com/yourusername/mismatch-dating.git
cd mismatch-dating

# Set up the database
cd mismatch
php ../database/setup_sqlite.php

# Start development server
php -S localhost:8000
```

## 📝 Coding Standards

### PHP Code Style
- Use PSR-12 coding standards
- Indent with 2 spaces
- Use meaningful variable names
- Add comments for complex logic
- Keep functions small and focused

### Example
```php
<?php
/**
 * Calculate mismatch percentage between two users
 * 
 * @param int $user1_id First user ID
 * @param int $user2_id Second user ID
 * @return float Mismatch percentage
 */
function calculateMismatchPercentage($user1_id, $user2_id) {
    // Implementation here
    return $percentage;
}
?>
```

### CSS Guidelines
- Use consistent naming conventions
- Organize styles logically
- Use modern CSS features (Grid, Flexbox)
- Keep selectors specific but not overly complex

### JavaScript (if added)
- Use ES6+ features
- Follow consistent naming conventions
- Add error handling
- Comment complex functions

## 🧪 Testing

### Manual Testing
Before submitting changes, test:
- [ ] User registration and login
- [ ] Profile creation and editing
- [ ] Questionnaire completion
- [ ] Matching algorithm
- [ ] File uploads
- [ ] Responsive design
- [ ] Cross-browser compatibility

### Automated Testing (Future)
We plan to add:
- Unit tests for PHP functions
- Integration tests for database operations
- Frontend tests for user interactions

## 📁 Project Structure

```
mismatch/
├── images/              # User uploads
├── *.php               # Main application files
├── style.css           # Styling
└── mismatch.db         # Database

database/
├── *.sql               # Schema files
└── setup_*.php         # Setup scripts

scripts/
├── start_*.sh          # Linux/Mac startup
└── start_*.bat         # Windows startup

docs/
├── *.md                # Documentation
└── test_*.php          # Test files
```

## 🔧 Common Development Tasks

### Adding New Questions
1. Edit `database/mismatch_topic.sqlite.sql`
2. Add new topics with appropriate categories
3. Update the questionnaire display logic
4. Test the new questions

### Modifying the Matching Algorithm
1. Locate the matching logic in `mymismatch.php`
2. Update the calculation method
3. Test with different user combinations
4. Update documentation

### Styling Changes
1. Modify `mismatch/style.css`
2. Test responsive design
3. Ensure cross-browser compatibility
4. Update screenshots if needed

## 🚀 Pull Request Process

### Before Submitting
1. **Test your changes thoroughly**
2. **Update documentation** if needed
3. **Follow coding standards**
4. **Keep commits atomic** (one change per commit)
5. **Write clear commit messages**

### Commit Message Format
```
type(scope): description

[optional body]

[optional footer]
```

Examples:
```
feat(matching): improve algorithm accuracy

fix(profile): resolve image upload issue

docs(readme): update installation instructions
```

### Pull Request Template
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Code refactoring

## Testing
- [ ] Manual testing completed
- [ ] Cross-browser testing done
- [ ] Mobile responsiveness verified

## Screenshots (if applicable)
Add screenshots of UI changes

## Checklist
- [ ] Code follows project standards
- [ ] Documentation updated
- [ ] No breaking changes
- [ ] Tests pass
```

## 🎯 Areas for Contribution

### High Priority
- Security improvements
- Performance optimization
- Bug fixes
- Documentation updates

### Medium Priority
- UI/UX improvements
- New features
- Code refactoring
- Testing infrastructure

### Low Priority
- Cosmetic changes
- Minor optimizations
- Additional documentation

## 📞 Getting Help

### Before Asking
1. Check existing issues and pull requests
2. Review documentation in `/docs`
3. Test with the provided test files

### Communication Channels
- GitHub Issues for bugs and features
- GitHub Discussions for questions
- Pull Request comments for code reviews

## 🏆 Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- GitHub contributors page

## 📋 Code of Conduct

### Our Standards
- Be respectful and inclusive
- Focus on constructive feedback
- Help others learn and grow
- Respect different perspectives

### Enforcement
- Unacceptable behavior will not be tolerated
- Violations may result in temporary or permanent ban
- Report issues to project maintainers

## 🔄 Release Process

### Versioning
We use [Semantic Versioning](https://semver.org/):
- MAJOR.MINOR.PATCH
- Example: 1.2.3

### Release Steps
1. Update version numbers
2. Update changelog
3. Create release tag
4. Deploy to production
5. Announce release

---

Thank you for contributing to Mismatch Dating Website! Your help makes this project better for everyone. 💕 