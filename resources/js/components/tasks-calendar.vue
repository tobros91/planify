<template>
<div>

    <div class="row">
        <div class="col">
            <i class="fas fa-chevron-left" @click="previousMonth()"></i>
            <i class="fas fa-chevron-right" @click="nextMonth()"></i>
            {{ periodMonth }}
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-1">
            Week
        </div>
        <div class="col">
            <div class="row no-gutters">
                <div class="col" v-for="day in ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']">
                    {{ day }}
                </div>
            </div>
        </div>
    </div>

    <div class="row no-gutters weekDaysRow" v-for="chunk in chunkedDates">

        <div class="col-1" style="font-size: 12px;">
            <h2>{{ chunk[0].week }}</h2>
        </div>

        <div class="col">

            <div class="row no-gutters" style="overflow: hidden;">

                <div style="position: relative; width: 100%;">

                    <div class="row row-tasks no-gutters"
                         :class="task.classOffset"
                         style="background-color: #8c8c8c;"
                         :style="{ top: tasksTop(task, chunk[0].date)+'px', 'z-index': (100+index) }"
                         v-for="(task, index) in chunk[0].tasks">

                        <div :class="[task.classWidth, task.classBorderLeft, task.classBorderRight]">
                            <span class="d-inline-block w-100 text-truncate">
                                <b>{{ task.title }}</b>
                            </span>
                        </div>

                    </div>

                </div>

                <div class="col date" v-for="date in chunk" v-bind:class="{ active: date.in_period }">
                    {{ date.day }}
                </div>

            </div>

        </div>

    </div>

</div>
</template>

<script>

    export default {

        props: {
            tasks: {
                required: true
            }
        },

        data ()
        {
            return {
                period: moment(),
            }
        },

        computed: {

            periodMonth ()
            {
                return moment(this.period).format('MMMM')
            },

            startOfMonth ()
            {
                return moment(this.period).startOf('month')
            },

            endOfMonth ()
            {
                return moment(this.period).endOf('month')
            },

            startOfPeriod ()
            {
                return moment(this.startOfMonth).startOf('isoWeek')
            },

            endOfPeriod ()
            {
                return moment(this.endOfMonth).endOf('isoWeek')
            },

            daysInPeriod ()
            {
                return this.endOfPeriod.diff(this.startOfPeriod, 'days', true)
            },

            dates ()
            {
                let dates = []

                for (var i = 0; i < this.daysInPeriod; i++) {
                    let tasks = []
                    const date = moment(this.startOfPeriod).add(i, 'days')
                    if(moment(date).day() == 1) {
                        var endOfWeek = moment(date).endOf('isoWeek')

                        _.forEach(this.tasksInRange(date, 'isoWeek'), function(task, index) {

                            var taskStartInWeek = (moment(task.starts_at).isSameOrAfter(moment(date), 'day') ? moment(task.starts_at).weekday() : 1)
                            var taskEndInWeek = (moment(task.ends_at).isSameOrBefore(endOfWeek, 'day') ? moment(task.ends_at).weekday() : 7)

                            task.taskStartInWeek = taskStartInWeek
                            task.taskEndInWeek = taskEndInWeek
                            task.classWidth = 'task-width-'+(taskEndInWeek - (taskStartInWeek - 1))
                            task.classOffset = 'task-offset-'+(taskStartInWeek - 1)
                            task.classBorderLeft = taskStartInWeek == 1 ? '' : 'rounded-left'
                            task.classBorderRight = taskEndInWeek == 7 ? '' : 'rounded-right'
                            task.top = 20 + (20 * index)

                            tasks.push(task)
                        })

                    }

                    dates.push({
                        date: moment(date),
                        week: moment(date).isoWeek(),
                        day: moment(date).date(),
                        tasks: _.orderBy(tasks, ['taskStartInWeek', 'taskWorkDaysInWeek'], ['asc', 'desc'])
                    })
                }
                return dates
            },

            chunkedDates()
            {
                return _.chunk(this.dates, 7);
            },

        },

        methods: {

            previousMonth ()
            {
                this.period = moment(this.period).subtract(1, 'month');
            },

            nextMonth ()
            {
                this.period = moment(this.period).add(1, 'month');
            },

            tasksInRange(startDate, range)
            {
                var start = moment(startDate);
                var end = moment(start).endOf(range)

                var tasks = _.filter(this.tasks, function(t) {
                    return moment(t.ends_at).isSameOrAfter(start, 'day')
                        &&
                        (
                            moment(t.starts_at).isSameOrBefore(start, 'day')
                            ||
                            moment(t.starts_at).isSameOrBefore(end, 'day')
                        )
                })

                console.log('tasks in range')
                console.log(tasks)

                return JSON.parse(JSON.stringify(tasks))
            },

            tasksTop(task, firstDateInWeek) {
                console.log('taskTop')
                console.log(task)

                console.log('firstDateInWeek')
                console.log(firstDateInWeek)

                let day = moment(firstDateInWeek).add(task.taskStartInWeek - 1, 'days')

                let tasks = [];
                let endOfWeek = moment(firstDateInWeek).endOf('isoWeek')
                _.forEach(this.tasksInRange(day, 'day'), (task, index) => {
                    var taskStartInWeek = (moment(task.starts_at).isSameOrAfter(firstDateInWeek, 'day') ? moment(task.starts_at).weekday() : 1)
                    var taskEndInWeek = (moment(task.ends_at).isSameOrBefore(endOfWeek, 'day') ? moment(task.ends_at).weekday() : 7)
                    var taskWorkDaysInWeek = (taskEndInWeek > 5 ? 5 : taskEndInWeek) - (taskStartInWeek - 1)

                    task.taskStartInWeek = taskStartInWeek
                    task.taskWorkDaysInWeek = taskWorkDaysInWeek
                    tasks.push(task)
                })

                let tasksInDay = _.orderBy(tasks, ['taskStartInWeek', 'taskWorkDaysInWeek'], ['asc', 'desc']);

                console.log('task spanning over '+day.toISOString())
                console.log(tasksInDay)

                let index = _.findIndex(tasksInDay, ['id', task.id]);

                console.log('index')
                console.log(index)

                return ((index + 1) * 20) + index
            },

        }

    }

</script>
