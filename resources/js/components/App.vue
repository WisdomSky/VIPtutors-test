<template>
    <div>
        <div v-for="(team, index) in teams" :key="team.code" class="team-row">
            <div class="item">
                <div class="name">{{ team.name }}</div>
                <div class="actions">
                    <a :href="`/team/${team.code}`" @click.prevent="viewRoster(team.code, index)">View Rosters</a>
                </div>
            </div>
            <div class="rosters" v-if="team.view_roster">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Position</th>
                            <th style="width: 100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="roster in team.rosters" :key="roster.id">
                            <td>{{ roster.name }}</td>
                            <td>{{ roster.number }}</td>
                            <td>{{ roster.pos }}</td>
                            <td class="roster-actions">
                                <a :href="`/roster/${roster.id}`" @click.prevent="showRosterDetails(roster.id)">Details</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal player-details" v-if="playerDetails !== false">
            <div style="text-align: right;border-bottom: 1px solid #ccc">
                <a href="#" @click.prevent="playerDetails = false">Close</a>
            </div>
            <div v-for="(val, key) in playerDetails">
                <strong>{{ key }}</strong>:&nbsp;{{ val }}
            </div>
        </div>
        <div class="export">
            <form method="GET" action="/export">
                <div>
                    <input type="text" name="player" placeholder="Player Name">
                    <input type="text" name="team" placeholder="Team Name">
                    <select name="type">
                        <option value="players">Select Result Type</option>
                        <option>players</option>
                        <option>playerstats</option>
                    </select>
                    <select name="format">
                        <option value="csv">Select File Type</option>
                        <option>csv</option>
                        <option>json</option>
                    </select>
                    <input type="submit" value="Export">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data: function () {
      return {
          teams: [],
          playerDetails: false,
          showExport: false,
          exportOptions: {
              format: 'csv',
              type: 'playerstats',
              team: '',
              player: ''
          }
      }
    },
    mounted() {
        axios.get('/team').then(({ data }) => {
            this.teams = data;
        })
    },
    methods: {
        viewRoster(team_code, index) {

            let team = this.teams[index];
            team.view_roster = !team.view_roster;

            if (team.rosters === undefined) {
                axios.get('/team/' + team_code ).then(({ data }) => {
                    team.rosters = data;

                    this.$set(this.teams, index, team);
                })
            }
        },
        showRosterDetails(roster_id){
            axios.get('/roster/' + roster_id ).then(({ data }) => {
                delete data.player_id;
                this.playerDetails = data;
            })
        }
    }
}
</script>

<style scoped lang="scss">
    .team-row {
        width: 500px;
        border: 3px solid #faa;
        border-radius: 10px;
        margin: 10px 0;
        padding: 10px;
        background: #fcc;
        box-sizing: border-box;
        color: #f55;

        a {
            color: #fff;
            text-decoration: underline;
        }

        .item {
            display: flex;
            flex-direction: row;

            .name {
                flex-grow: 1;
            }
            .actions {
                width: 250px;
                text-align: right;

                a {
                    margin-left: 10px;
                }
            }
        }

        .roster-actions {
            a {
                margin-left: 10px;
            }
        }

    }

    .modal.player-details {
        width: 500px;
        min-height: 350px;
        background: #ccc;
        border: 2px solid #777;
        border-radius: 10px;
        padding: 10px;
        position: fixed;
        z-index: 1000;
        left: 50%;
        top: 100px;
        margin-left: -250px;
    }

    button {
        background: #f77;
        color: #fff;
        border-radius: 5px;
        padding: 5px 15px;
        cursor: pointer;
    }


    .export {
        margin-top: 20px;
        border-top: 1px solid #f77;
        input, select {
            border: 1px solid #f77;
            padding: 5px;
            margin: 10px;
            border-radius: 5px;
        }
        input[type=submit] {
            background: #fcc;
            color: #fff;
        }
    }

</style>
