package com.example.splashapp;

import android.graphics.Bitmap;
import android.os.AsyncTask;
import android.util.Base64;
import android.util.Log;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.reflect.TypeToken;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.nio.charset.StandardCharsets;
import java.security.MessageDigest;
import java.util.Collections;
import java.util.List;
import java.util.concurrent.ExecutionException;

import okhttp3.FormBody;
import okhttp3.MediaType;
import okhttp3.MultipartBody;
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
    private  String anotherlcorg = "http://darapana.beget.tech/api/org_profile";
    private  String updcit = "http://darapana.beget.tech/api/c_upd_";
    private  String updorg = "http://darapana.beget.tech/api/o_upd_";
    private  String listorgs = "http://darapana.beget.tech/api/lenta_org";
    private  String listfavorgs = "http://darapana.beget.tech/api/show_fav";
    public static int numberorglist=0;
    private static int lastlistorgnum=0;
    public static int numberpost=0;
    private static int lastpostnum=0;
    public static boolean isload=false;
    private  String posts = "http://darapana.beget.tech/api/lenta_posts";
    private  String postsadd = "http://darapana.beget.tech/api/post_add";


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
            M_Citizen cit = gson.fromJson(result, M_Citizen.class); //LсCit(json.get("id").toString());
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

    public M_Organization AnotherOrg(String params) {
        link = anotherlcorg;
        formBody = new FormBody.Builder()
                .add("Authorzation", "")
                .add("Accept", "aplication/json")
                .add("id", params)
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            orgs=orgs.replace(",\"image\":[",",\"photo\":[");
            String result = orgs;//orgs.substring(orgs.indexOf("data")+6, orgs.indexOf("message") -2);
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

    public boolean updImgae(String[] params, Bitmap bmp)
    {
        link="http://darapana.beget.tech/api/add_userpic";
        try {
            ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
            bmp.compress(Bitmap.CompressFormat.PNG, 100, byteArrayOutputStream);
            byte[] byteArray = byteArrayOutputStream .toByteArray();
            String encoded = Base64.encodeToString(byteArray, Base64.DEFAULT);
            formBody = new FormBody.Builder()
                    .add("id", params[0])
                    .add("extension","png")
                    .add("hash", encoded)
                    .build();
            AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);

            try {
               String answer = fpl.get().toString();
            }catch (Exception e) {
                Log.e("", e.getMessage());
            }
            return true;

        } catch (Exception e) {
            Log.e("", "Error: ");
        }
        return false;
    }

    public List<M_Organization> ListOrgs(int param, String type) {
        link = listorgs;
        isload=true;
        formBody = new FormBody.Builder()
                .add("offset", Integer.toString(param))
                .add("typeActive",type)
                .build();

        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            orgs=orgs.replace("[],","");
            String result = orgs.substring(orgs.lastIndexOf("},")+2, orgs.length() -1);
            orgs=orgs.replace("},"+result,"},");
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            List<M_Organization> orgslist = gson.fromJson(orgs, new TypeToken<List<M_Organization>>(){}.getType());
            orgslist.removeAll(Collections.singleton(null));
            numberpost=Integer.parseInt(result);
            return orgslist;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        finally {
            isload=false;
        }
        return null;
    }

    public List<M_Organization> ListFavOrgs(String param) {
        link = listfavorgs;
        isload=true;
        formBody = new FormBody.Builder()
                .add("id_cit", param)
                .build();

        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            orgs=orgs.replace("\"id\"","\"fav_id\"");
            orgs=orgs.replace("id_organization","id");
            orgs=orgs.replace("org_name","name");
            orgs=orgs.replace("org_photo","picture");
            String result = orgs.substring(orgs.indexOf("data")+6, orgs.indexOf("message") -2);
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            List<M_Organization> orgslist = gson.fromJson(result, new TypeToken<List<M_Organization>>(){}.getType());
            orgslist.removeAll(Collections.singleton(null));
            //numberpost=Integer.parseInt(result);
            return orgslist;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        finally {
            isload=false;
        }
        return null;
    }

    public boolean SaveDelFavOrg(String[] param, boolean save)
    {
        if (save) {
            link = "http://darapana.beget.tech/api/add_fav";
        }
            else {
            link = "http://darapana.beget.tech/api/del_fav_by_id";}


        formBody = new FormBody.Builder()
                .add(param[2], param[0])
                .add(param[3], param[1])
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String answ = fpl.get().toString();
            return true;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        return false;
    }


    public List<M_Post> ListPosts(int param, String id) {
        link = posts;
        isload=true;
        formBody = new FormBody.Builder()
                .add("offset", Integer.toString(param))
                .add("filter", "all")
                .add("id_citizen", id)
                .build();

        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String orgs = fpl.get().toString();
            //orgs=orgs.replace("[]","");
            //orgs=orgs.replace("},[",",\"image\":[");
            //orgs=orgs.replace("],{","]},{");
            String result = orgs.substring(orgs.lastIndexOf("},")+2, orgs.length() -1);
            orgs=orgs.replace("},"+result,"}");
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            List<M_Post> orgslist = gson.fromJson(orgs, new TypeToken<List<M_Post>>(){}.getType());
            orgslist.removeAll(Collections.singleton(null));
            numberpost=Integer.parseInt(result);
            return orgslist;
        } catch (InterruptedException e) {
            e.printStackTrace();
        } catch (ExecutionException e) {
            e.printStackTrace();
        } catch (Exception e) {
            Log.d("Exe", e.getMessage());
        }
        finally {
            isload=false;
        }
        return null;
    }

    public boolean AddPost(String [] params, Bitmap[] bmp) {
        link = postsadd;
        String[] encoded=new String[3];
        for (int i=0; i<bmp.length;i++) {
            if (bmp[i]!=null) {
                ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                bmp[i].compress(Bitmap.CompressFormat.PNG, 100, byteArrayOutputStream);
                byte[] byteArray = byteArrayOutputStream.toByteArray();
                encoded[i] = Base64.encodeToString(byteArray, Base64.DEFAULT);
            }
            else {
                encoded[i] = "";
            }
        }
        formBody = new FormBody.Builder()
                .add("id_organizations", params[3])
                .add("title", params[0])
                .add("text", params[1])
                .add("date_added", params[2])
                .add("ext1", "png")
                .add("img1", encoded[0])
                .add("ext2", "png")
                .add("img2", encoded[1])
                .add("ext3", "png")
                .add("img4", encoded[2])
                .build();
        AsyncTask fpl = new Connection().executeOnExecutor(AsyncTask.SERIAL_EXECUTOR);
        try {
            String cits = fpl.get().toString();
            json=new JSONObject(cits);
            //String good=json.get("success").toString();
            if (json==null)
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

/* String orgs = fpl.get().toString();
            orgs=orgs.replace("[],","");
            String result = orgs.substring(orgs.lastIndexOf("],")+2, orgs.length() -1);
            orgs=orgs.replace("],"+result,"],");
            GsonBuilder builder = new GsonBuilder();
            Gson gson = builder.create();
            List<M_Activism> orgslist = gson.fromJson(orgs, new TypeToken<List<M_Activism>>(){}.getType());
            orgslist.removeAll(Collections.singleton(null));
            if (numberpost==0)
            {numberpost=(Integer.parseInt(orgslist.get(0).getId())-Integer.parseInt(orgslist.get(4).getId()))+1;}
            else
            {numberpost+=lastpostnum-Integer.parseInt(orgslist.get(orgslist.size()-1).getId());}
            lastpostnum=Integer.parseInt(orgslist.get((orgslist.size()-1)).getId());
            return orgslist;*/