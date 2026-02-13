# MoustCamara.com AI Agent System

This directory contains specialized AI agent personas that help build the MoustCamara.com website efficiently. Each agent has specific expertise and can be invoked by referencing their role.

## The Agent Family

### 🎨 [Design System Agent](./design-system-agent.md)
**Expertise**: UX/UI patterns, WordPress blocks, layout structures  
**Use for**: Page layouts, block selection, design patterns, visual hierarchy

### ✍️ [Content Strategist Agent](./content-strategist-agent.md)
**Expertise**: Microcopy, messaging, content hierarchy, voice & tone  
**Use for**: Headlines, CTAs, copy, positioning, placeholder content

### 📸 [Visual Asset Planner Agent](./visual-asset-planner-agent.md)
**Expertise**: Photo/video requirements, photographer briefs  
**Use for**: Shot lists, asset specs, photographer briefs, asset-to-page mapping

### 🔧 [WordPress Builder Agent](./wordpress-builder-agent.md)
**Expertise**: Technical implementation, theme/plugin development  
**Use for**: Code implementation, bug fixes, configuration, optimization

## How to Use

### Invoking Agents

Simply reference the agent's role in your request:

```
"Design System Agent: What should my services page layout look like?"

"Content Strategist: Write microcopy for the hero CTA button"

"Visual Asset Planner: Create a shot list for the About page"

"WordPress Builder: Implement a custom testimonial block"
```

### Multi-Agent Workflows

Complex tasks often require multiple agents:

1. **Design System** → layout structure
2. **Content Strategist** → copy for that layout
3. **Visual Asset Planner** → photos needed for that layout
4. **WordPress Builder** → implement the layout

Example:
```
"I need to build a Services page. 

Design System: Show me a layout that works for my three services
Content Strategist: Write the service descriptions
Visual Asset Planner: What photos do I need?
WordPress Builder: Implement using ACF blocks"
```

## Current Context

**Site**: MoustCamara.com  
**Owner**: Moust Camara  
**Positioning**: Founder/thought-leader in tech + music tech products + musician  
**Services**: Business coaching, fractional CTO, tech audits  
**Content**: Think pieces, article guides, service marketing  
**Timeline**: Photoshoot in 2 days, need design complete to inform asset creation

## Project Status

- **Phase**: Pseudo-building site with placeholder content
- **Goal**: Design complete before photoshoot
- **Priority**: Know exactly what photos/videos go where
- **Theme**: moustcamara-plain (custom ACF blocks)

## Agent Coordination

Agents can work together on the same task. They'll coordinate to provide:
- Holistic solutions that consider design, content, assets, and implementation
- Consistent recommendations across disciplines
- Efficient workflows that minimize rework

## Quick Reference

| Need | Agent |
|------|-------|
| Page layout ideas | 🎨 Design System |
| Button/CTA text | ✍️ Content Strategist |
| Photo specifications | 📸 Visual Asset Planner |
| Code implementation | 🔧 WordPress Builder |
| Block selection | 🎨 Design System |
| Headline writing | ✍️ Content Strategist |
| Shot list creation | 📸 Visual Asset Planner |
| Plugin configuration | 🔧 WordPress Builder |
