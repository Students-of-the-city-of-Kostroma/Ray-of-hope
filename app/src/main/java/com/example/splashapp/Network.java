package com.example.splashapp;

import android.os.AsyncTask;
import android.util.Log;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import org.json.JSONObject;
import java.util.concurrent.ExecutionException;

import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Network {

    private  String regorg = "http://darapana.beget.tech/api/register_o";
    private  String loginorg = "http://darapana.beget.tech/api/organization";
    private  String regcit = "http://darapana.beget.tech/api/register_c";
    private  String logincit = "http://darapana.beget.tech/api/citizen";
    private  String lccit = "http://darapana.beget.tech/api/lc_citizen";
    private  String lcorg = "http://darapana.beget.tech/api/lc_organization";
    private  String updcit = "http://darapana.beget.tech/api/c_upd_";
    private  String updorg = "http://darapana.beget.tech/api/o_upd_";


    private static String link;
    private JSONObject json;
    public static RequestBody formBody;
    public String RegOrg(String [] params) {
        link = regorg;
                formBody = new FormBody.Builder()
                .add("name", params[0])
                .add("inn", params[1])
                .add("email", params[2])
                .add("password", params[3])
                .add("c_password", params[4])
                .build();

        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            return orgs;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return null;
    }

    public M_Citizen RegCit(String [] params) {
        link = regcit;
        formBody = new FormBody.Builder()
                .add("name", params[0])
                .add("f_name", params[1])
                .add("o_name", params[2])
                .add("email", params[3])
                .add("password", params[4])
                .add("c_password", params[5])
                .build();

        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String cits = fpl.get().toString();
            String result = cits.substring(cits.indexOf("data")+6, cits.indexOf("message") -2);
            json=new JSONObject(result);
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            M_Citizen cit = gson.fromJson(result, M_Citizen.class);
            return cit;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return null;
    }

    public M_Organization LoginOrg(String [] params) {
        link = loginorg;
        formBody = new FormBody.Builder()
                .add("Authorzation", "")
                .add("Accept", "aplication/json")
                .add("email", params[0])
                .add("password", params[1])
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            String result = orgs.substring(orgs.indexOf("data")+6, orgs.indexOf("message") -2);
            json=new JSONObject(result);
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            M_Organization org = gson.fromJson(result, M_Organization.class);
            return org;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return null;
    }

    public M_Citizen LoginCit(String [] params) {
        link = logincit;
        formBody = new FormBody.Builder()
                .add("Authorzation", "")
                .add("Accept", "aplication/json")
                .add("email", params[0])
                .add("password", params[1])
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String cits = fpl.get().toString();
            String result = cits.substring(cits.indexOf("data")+6, cits.indexOf("message") -2);
            json=new JSONObject(result);
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            M_Citizen cit = gson.fromJson(result, M_Citizen.class);
            return cit;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return null;
    }

    public M_Organization LсOrg(String params) {
        link = lcorg;
        formBody = new FormBody.Builder()
                .add("Authorzation", "")
                .add("Accept", "aplication/json")
                .add("id", params)
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            String result = orgs.substring(orgs.indexOf("data")+6, orgs.indexOf("message") -2);
            json=new JSONObject(result);
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            M_Organization org = gson.fromJson(result, M_Organization.class);
            return org;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return null;
    }

    public M_Citizen LсCit(String params) {
        link = lccit;
        formBody = new FormBody.Builder()
                .add("Authorzation", "")
                .add("Accept", "aplication/json")
                .add("id", params)
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String cits = fpl.get().toString();
            String result = cits.substring(cits.indexOf("data")+6, cits.indexOf("message") -2);
            json=new JSONObject(result);
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            M_Citizen cit = gson.fromJson(result, M_Citizen.class);
            return cit;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return null;
    }

    public boolean UpdCit(String[] params) {
        link = updcit+params[0];
        formBody = new FormBody.Builder()
                .add("id", params[3])
                .add(params[1], params[2])
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String cits = fpl.get().toString();
            json=new JSONObject(cits);
            String good=json.get("success").toString();
            if (good.equals("true"))
            return true;
            else return  false;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return false;
    }

    public boolean UpdOrg(String[] params) {
        link = updorg+params[0];
        formBody = new FormBody.Builder()
                .add("id", params[3])
                .add(params[1], params[2])
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String cits = fpl.get().toString();
            json=new JSONObject(cits);
            String good=json.get("success").toString();
            if (good.equals("true"))
                return true;
            else return  false;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return false;
    }

    private static class Connection extends AsyncTask<String, String, String> {
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        protected String doInBackground(String... args) {
            OkHttpClient client = new OkHttpClient();

            RequestBody formBody = Network.formBody;
            Request request = new Request.Builder()
                    .url(link)
                    .post(formBody)
                    .build();
            try {
                Response response = client.newCall(request).execute();

                return response.body().string();
            } catch (Exception e) {
                Log.d("Fail Image", "png");
            }
            return null;
        }

        protected void onPostExecute(String file_url) {
        }
    }
}

/* {


    private M_Organization Organization;
    public CallDB_RegOrg(){}

    String link ="http://darapana.beget.tech/api/register_o";
    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected void onPostExecute(String result) {
        super.onPostExecute(result);
    }

    @Override
    protected String doInBackground(String... params) {
        OkHttpClient client = new OkHttpClient();

        RequestBody formBody = new FormBody.Builder()
                .add("name", params[0])
                .add("inn", params[1])
                .add("email", params[2])
                .add("password", params[3])
                .add("c_password", params[4])
                .build();

        Request request = new Request.Builder()
                .url(link)
                .post(formBody)
                .build();
        try {
            Response response = client.newCall(request).execute();

            return response.body().string();
        } catch (Exception e) {
            Log.d("", e.getMessage());
        }
        return null;
    }
}

*/