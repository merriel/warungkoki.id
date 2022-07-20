using SQLite;
using System;
using System.Collections.Generic;
using System.Text;
using System.Threading.Tasks;
using warungkoki.id.Models;

namespace warungkoki.id.Services
{
    public class TodoItemDatabase
    {
        static SQLiteAsyncConnection Database;

        public static readonly AsyncLazy<TodoItemDatabase> Instance = new AsyncLazy<TodoItemDatabase>(async () =>
        {
            var instance = new TodoItemDatabase();
            CreateTableResult result = await Database.CreateTableAsync<Favorit>();
            return instance;
        });

        public TodoItemDatabase()
        {
            Database = new SQLiteAsyncConnection(Constants.DatabasePath, Constants.Flags);
        }

        public Task<List<Favorit>> GetItemsAsync()
        {
            return Database.Table<Favorit>().ToListAsync();
        }

        public Task<List<Favorit>> GetItemsNotDoneAsync()
        {
            // SQL queries are also possible
            return Database.QueryAsync<Favorit>("SELECT * FROM [Favorit] WHERE [Done] = 0");
        }

        public Task<Favorit> GetItemAsync(int id)
        {
            return Database.Table<Favorit>().Where(i => i.id_fav == id).FirstOrDefaultAsync();
        }

        public Task<int> SaveItemAsync(Favorit item)
        {
            if (item.id_fav != 0)
            {
                return Database.UpdateAsync(item);
            }
            else
            {
                return Database.InsertAsync(item);
            }
        }

        public Task<int> DeleteItemAsync(Favorit item)
        {
            return Database.DeleteAsync(item);
        }
    }
}
