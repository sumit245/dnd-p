<?php
/**
 * Per-product FAQs for demo pages, keyed by portfolio slug.
 *
 * Single source of truth: demo/_template.php renders both the visible
 * accordion and the FAQPage JSON-LD from this array, so the markup and the
 * structured data can never drift apart.
 *
 * Answers are plain text (no HTML) because they are emitted into JSON-LD.
 * Keep every claim verifiable. Structured data does not guarantee rich results.
 */

return [

    'hms' => [
        [
            'q' => 'What is a hospital management system demo?',
            'a' => 'A hospital management system demo is a sample environment for evaluating how hospital software handles patient registration, appointments, records and billing. Use it to compare a workflow with your own process before agreeing an implementation scope.',
        ],
        [
            'q' => 'What should we check in an HMS dashboard?',
            'a' => 'Start with a specific task: find an appointment, follow a patient visit, or review a bill. Check which roles can view and edit the record, how corrections are handled, and whether the report answers your operational question. Confirm any module you cannot access during a guided walkthrough.',
        ],
        [
            'q' => 'What is the difference between OPD, IPD and EMR?',
            'a' => 'OPD means outpatient department, for visits without admission. IPD means inpatient department, for admitted patients. EMR means electronic medical record, the digital record of a patient\'s clinical information. Check how records move between these workflows when evaluating an HMS.',
        ],
        [
            'q' => 'What should we prepare for a hospital software walkthrough?',
            'a' => 'Bring a list of departments, staff roles, appointment steps, billing scenarios, reports and existing systems that need to connect. Use fictional patient examples. Ask which requirements are included in the demo and which need separate configuration or development; a demo alone does not establish suitability for production use.',
        ],
    ],

    'hrmx' => [
        [
            'q' => 'Is HRMX a subscription?',
            'a' => 'No. HRMX is a one-time build fee plus a yearly AMC, and there is no per-employee licence. What you pay for the software does not increase every time you hire.',
        ],
        [
            'q' => 'What does the yearly AMC cover?',
            'a' => 'Bug fixes and security updates, with support available 24/7 on whichever channel suits you. Cosmetic changes and new features are not included in the AMC; they are scoped and quoted separately.',
        ],
        [
            'q' => 'What drives the cost of an HRMX project?',
            'a' => 'In order of impact: data migration from your existing system, where you choose to host it, biometric and device integration, custom modules outside the standard list, payroll component complexity, the number of branches and locations, and lastly headcount. Headcount is the cheapest variable in a custom build and the most expensive one in a subscription.',
        ],
        [
            'q' => 'Where is our HR data hosted?',
            'a' => 'By default on secured AWS infrastructure in the Mumbai region, with daily backups. Where it lives is your decision though: on-premise, your own cloud account, or ours. Because HRMX is a custom build rather than a SaaS tenancy, hosting is a choice you make rather than one you inherit.',
        ],
        [
            'q' => 'Who at Dashandots can see our data?',
            'a' => 'Only the support team, and only in order to support you. An NDA is signed before the engagement begins.',
        ],
        [
            'q' => 'Do we own the system?',
            'a' => 'Yes. The client owns the intellectual property. The system stays yours, including on the day you stop working with us.',
        ],
        [
            'q' => 'How long does an HRMX implementation take?',
            'a' => 'Eight to ten weeks from NDA to go-live, at roughly a week per stage, including two to three parallel payroll cycles run alongside your existing process before cutover.',
        ],
        [
            'q' => 'Can you migrate our data from Tally, MARG or Odoo?',
            'a' => 'Yes, and from unnamed legacy systems too. Migration is the largest single cost driver on most HRMX projects because every system stores employees, salary structures and leave balances differently and few export cleanly. We guide the migration with mapping, templates and validation, and your team performs it.',
        ],
        [
            'q' => 'We run everything on spreadsheets today. Is that harder to migrate?',
            'a' => 'Easier, not harder. A spreadsheet maps cleanly, while a closed legacy system with no usable export does not. Most companies assume the reverse and budget the wrong way round.',
        ],
        [
            'q' => 'Can different branches have different leave policies?',
            'a' => 'Yes, and so can different departments inside the same branch. Each one can run its own leave rules, approval chains and working patterns while payroll still runs as a single process.',
        ],
        [
            'q' => 'Can HRMX track staff who move between sites during a shift?',
            'a' => 'Yes. Staff punch from their phone with a photo, geofenced to a 90-metre radius of the location they are assigned to, with rotating shifts that follow them from one site to the next. It was built for a security agency whose guards move between posts, and it applies to any field, multi-site or roving team.',
        ],
        [
            'q' => 'What kinds of workforce can HRMX handle?',
            'a' => 'From daily-wage and unstructured labour through to salaried corporate staff, inside one system. Companies with 20 to 1,000 employees are the usual fit, and the largest live deployment runs 1,200+ employees.',
        ],
        [
            'q' => 'Is there a minimum company size?',
            'a' => 'Below roughly 20 employees we will tell you to subscribe to a SaaS HRMS instead. A custom build does not pay back at that size.',
        ],
        [
            'q' => 'What do you need from us to start?',
            'a' => 'Your policies, employee master, salary structures and past leave balances. In practice the biggest delay is not the data or the software, it is HR and management agreeing on payout decisions, so settling those early shortens the project.',
        ],
        [
            'q' => 'How are our people trained?',
            'a' => 'Four on-premise sessions and six online sessions, all recorded, so employees who join later can catch up without scheduling anything.',
        ],
        [
            'q' => 'Can we see HRMX before committing?',
            'a' => 'Yes. A full working demo runs at hrmx.dashandots.com. Email us or use the contact form and we will share access.',
        ],
    ],

];
