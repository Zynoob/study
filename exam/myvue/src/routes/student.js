export default [{
        path: '/student',
        name: 'student',
        component: () => import("../views/student/Index.vue"),
        children: [{
                path: 'myscore',
                name: 'student_myscore',
                component: () => import('../views/student/MyScore.vue')
            },
            {
                path: 'choicepaper',
                name: 'student_choicepaper',
                component: () => import('../views/student/ChoicePaper.vue'),
            },
            {
                path: 'exam',
                name: 'student_exam',
                component: () => import('../views/student/PaperInfo.vue'),
                props: (route) => ({ id: route.query.id })
            }
        ]
    },
    {
        path: '/student/personinfo',
        name: 'student_personinfo',
        component: () => import('../views/student/PersonInfo.vue'),
        children: [{
                path: 'baseinfo',
                name: 'student_baseinfo',
                component: () => import('../views/student/BaseInfo.vue')
            },
            {
                path: 'modifypwd',
                name: 'student_modifypwd',
                component: () => import('../views/student/ModifyPassword.vue')
            },
        ]
    }
]