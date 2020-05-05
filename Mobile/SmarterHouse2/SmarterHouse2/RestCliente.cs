using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace SmarterHouse2
{
    class RestCliente
    {

        public async Task<T> Get<T>(string url)
        {
            try
            {
                HttpClient cliente = new HttpClient();
                var response = await cliente.GetAsync(url);
                if (response.StatusCode == System.Net.HttpStatusCode.OK)
                {
                    var jsonstring = await response.Content.ReadAsStringAsync();
                    return Newtonsoft.Json.JsonConvert.DeserializeObject<T>(jsonstring);
                }


            }
            catch (Exception)
            {

                throw;
            }

            return default(T);
        }
        public async Task<T> Post<T>(string url)
        {
            try
            {
                HttpClient cliente = new HttpClient();
                var post = new Usuario { method = "1", senha = "smarterhouse" };
                var content = JsonConvert.SerializeObject(post);

                var response = await cliente.PostAsync(url, new StringContent(content));


                var jsonstring = await response.Content.ReadAsStringAsync();
                return Newtonsoft.Json.JsonConvert.DeserializeObject<T>(jsonstring);



            }
            catch (Exception)
            {

                throw;
            }


        }

    }
}