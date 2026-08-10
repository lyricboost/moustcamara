# Table Grid Block - Visual Examples

## Example 1: Service Packages

### Setup
**Heading**: "Choose Your Package"
**Subheading**: "Flexible options to match your needs"
**Columns**: 3

### Configuration

#### Columns
| Column | Name | Highlight | Button Text | Button Link |
|--------|------|-----------|-------------|-------------|
| 1 | Consultation | No | Book Session | /contact |
| 2 | Implementation | Yes | Get Started | /services/implementation |
| 3 | Full Partnership | No | Let's Talk | /contact |

#### Feature Groups

**Group 1: Core Services**
| Feature | Consultation | Implementation | Full Partnership |
|---------|--------------|----------------|------------------|
| Initial Assessment | ✓ | ✓ | ✓ |
| Strategy Document | ✓ | ✓ | ✓ |
| Implementation Support | — | ✓ | ✓ |
| Ongoing Support | — | 3 months | 12 months |

**Group 2: Deliverables**
| Feature | Consultation | Implementation | Full Partnership |
|---------|--------------|----------------|------------------|
| Detailed Report | ✓ | ✓ | ✓ |
| Custom Templates | — | ✓ | ✓ |
| Training Sessions | — | 2 sessions | Unlimited |
| Priority Support | — | — | ✓ |

### Result Preview
```
┌─────────────────────────────────────────────────────────────┐
│              Choose Your Package                             │
│         Flexible options to match your needs                │
│                                                              │
│ Core Services  │ Consultation │ Implementation │ Partnership│
│ ══════════════════════════════════════════════════════════  │
│ Assessment     │      ✓       │       ✓        │     ✓      │
│ Strategy Doc   │      ✓       │       ✓        │     ✓      │
│ Implementation │      —       │       ✓        │     ✓      │
│ Support        │      —       │   3 months     │ 12 months  │
│ ══════════════════════════════════════════════════════════  │
│ Deliverables   │              │                │            │
│ Report         │      ✓       │       ✓        │     ✓      │
│ Templates      │      —       │       ✓        │     ✓      │
│ Training       │      —       │   2 sessions   │ Unlimited  │
│ Priority       │      —       │       —        │     ✓      │
│                │              │                │            │
│                │[Book Session]│ [Get Started]  │[Let's Talk]│
└─────────────────────────────────────────────────────────────┘
```

---

## Example 2: Pricing Tiers

### Setup
**Heading**: "Simple, Transparent Pricing"
**Subheading**: "Choose the plan that's right for you"
**Columns**: 3
**Background**: Light Gray

### Configuration

#### Columns
| Column | Name | Highlight | Button Text | Button Link |
|--------|------|-----------|-------------|-------------|
| 1 | Starter | No | Start Free | /signup?plan=starter |
| 2 | Professional | Yes | Start Trial | /signup?plan=pro |
| 3 | Enterprise | No | Contact Us | /contact |

#### Feature Groups

**Group 1: Storage & Users**
| Feature | Starter | Professional | Enterprise |
|---------|---------|--------------|------------|
| Storage Space | 10 GB | 100 GB | Unlimited |
| Team Members | 1 user | 10 users | Unlimited |
| File Upload Size | 25 MB | 500 MB | 5 GB |

**Group 2: Features**
| Feature | Starter | Professional | Enterprise |
|---------|---------|--------------|------------|
| Basic Templates | ✓ | ✓ | ✓ |
| Custom Branding | — | ✓ | ✓ |
| API Access | — | ✓ | ✓ |
| Priority Support | — | ✓ | ✓ |
| Dedicated Manager | — | — | ✓ |

### Mobile View
On mobile (< 920px), this transforms to:

```
▼ Storage Space
  Starter: 10 GB
  Professional: 100 GB
  Enterprise: Unlimited

▼ Team Members
  Starter: 1 user
  Professional: 10 users
  Enterprise: Unlimited

[Buttons at bottom]
```

---

## Example 3: Product Comparison

### Setup
**Heading**: "Find Your Perfect Fit"
**Columns**: 4
**Reduced Padding**: Yes

### Configuration

#### Columns
| Column | Name | Highlight |
|--------|------|-----------|
| 1 | Basic | No |
| 2 | Plus | No |
| 3 | Pro | Yes |
| 4 | Max | No |

#### Feature Groups

**Group 1: Core Specs**
| Feature | Basic | Plus | Pro | Max |
|---------|-------|------|-----|-----|
| RAM | 8 GB | 16 GB | 32 GB | 64 GB |
| Storage | 256 GB | 512 GB | 1 TB | 2 TB |
| Processor | i5 | i7 | i9 | i9 Pro |

**Group 2: Display**
| Feature | Basic | Plus | Pro | Max |
|---------|-------|------|-----|-----|
| Size | 13" | 14" | 16" | 16" |
| Resolution | 1080p | 1440p | 4K | 4K |
| Refresh Rate | 60Hz | 90Hz | 120Hz | 144Hz |

---

## Tips for Great Tables

### Column Names
✅ **Good**: "Starter", "Pro", "Enterprise"
❌ **Avoid**: "Plan A", "Option 2", "Package"

### Feature Names
✅ **Good**: "Storage Space", "Team Members", "API Access"
❌ **Avoid**: "How much stuff you can store", "Users", "API"

### Value Types

**Use Checkmarks For:**
- Binary yes/no features
- Standard inclusions
- Simple availability

**Use Text For:**
- Quantities (GB, users, etc.)
- Durations (months, sessions)
- Specifications (speeds, sizes)

**Use Dash (—) For:**
- Not available
- Not applicable
- Clear absence

### Tooltips Best Practices

Add tooltips for:
- Technical terms
- Unique features
- Clarifications
- Legal/compliance items

Example tooltips:
- "SSO" → "Single Sign-On: Log in once to access all services"
- "99.9% SLA" → "Service Level Agreement: Guaranteed uptime"
- "API Rate Limit" → "Maximum API calls per hour"

---

## Accessibility Checklist

- [ ] Feature names are descriptive
- [ ] Tooltips provide helpful context
- [ ] Button text is actionable
- [ ] Color is not the only differentiator
- [ ] Table has logical reading order
- [ ] Works with keyboard navigation
- [ ] Mobile accordion is touch-friendly

---

## Common Use Cases

### 1. SaaS Pricing
- 3 columns (Free, Pro, Enterprise)
- Storage/users/features comparison
- Highlight most popular plan
- Monthly/annual toggle (custom implementation)

### 2. Service Tiers
- 2-3 columns (packages)
- Deliverables and support levels
- Time-based comparisons
- Consultation CTAs

### 3. Product Specs
- 3-4 columns (models)
- Technical specifications
- Feature availability
- "Buy Now" or "Learn More" CTAs

### 4. Membership Levels
- 2-4 columns (tiers)
- Benefits and perks
- Access levels
- "Join Now" CTAs

### 5. Feature Comparison
- Any number of columns
- Competitive analysis
- Capability matrix
- "Choose Plan" CTAs

---

**Pro Tip**: Keep your first feature group as your most important differentiators. Users often scan the top of comparison tables most carefully!
