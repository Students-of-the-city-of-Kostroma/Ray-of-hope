package com.example.splashapp;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.squareup.picasso.Picasso;

import java.io.FileNotFoundException;
import java.io.InputStream;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class AddPostActivity extends AppCompatActivity {

    ImageView imageView;
    Bitmap selectedImage;
    int photocounter=0;
    List<Bitmap> bmp=new ArrayList<Bitmap>();
    List<ImageView> iv=new ArrayList<ImageView>();
    final String DATE_FORMAT_NOW = "yyyy-MM-dd HH:mm:ss";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_post);
        iv.add((ImageView) findViewById(R.id.p1));
        iv.add((ImageView) findViewById(R.id.p2));
        iv.add((ImageView) findViewById(R.id.p3));
    }

    public  void createPost(View view)
    {
        String[] input=new String[4];
        TextView textview= (TextView) findViewById(R.id.editText15);
        input[0]=textview.getText().toString();

        textview= (TextView) findViewById(R.id.editText16);
        input[1]=textview.getText().toString();

        Calendar cal = Calendar.getInstance();
        SimpleDateFormat sdf = new SimpleDateFormat(DATE_FORMAT_NOW);
        input[2]=sdf.format(cal.getTime());
        input[3]=C_Organization.MyOrg.getId();
        new Network().AddPost(input, bmp);
        finish();
    }

    public void AddPhoto(View view) {
        if (photocounter>2) {
            Toast toast = Toast.makeText(getApplicationContext(),
                    "Можно приложить не больше трех изображений", Toast.LENGTH_SHORT);
            toast.show();
            return;
        }
        Intent photoPickerIntent = new Intent(Intent.ACTION_PICK);
        photoPickerIntent.setType("image/*");
        startActivityForResult(photoPickerIntent, 0);
    }

    public void DelPhoto(View view)
    {

        AlertDialog.Builder adb = new AlertDialog.Builder(this);
        adb.setMessage("Удалить фото?");
        adb.setNegativeButton("Нет", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                return;
            };
        });
        final View v=view;
        adb.setPositiveButton("Да", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                photocounter--;

                if (v==findViewById(R.id.p1))
                    bmp.remove(0);
                if (v==findViewById(R.id.p2))
                    bmp.remove(1);
                if (v==findViewById(R.id.p3))
                    bmp.remove(3);


                iv.get(0).setImageDrawable(null);
                iv.get(1).setImageDrawable(null);
                iv.get(2).setImageDrawable(null);
                    for (int i = 0; i < bmp.size(); i++) { iv.get(i).setImageBitmap(bmp.get(i));
                }

            };
        });

        adb.show();
    }


    @Override
    protected void onActivityResult(int reqCode, int resultCode, Intent data) {
        super.onActivityResult(reqCode, resultCode, data);


        if (resultCode == -1) {
            try {
                final Uri imageUri = data.getData();
                final InputStream imageStream = getContentResolver().openInputStream(imageUri);
                bmp.add(BitmapFactory.decodeStream(imageStream));
                iv.get(photocounter).setImageBitmap(bmp.get(photocounter));
                photocounter++;
            } catch (FileNotFoundException e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    public void onBackPressed() {
        Cancel(MyOrgProf.class);
    }

    public void Cancel(Class<?> t)
    {
        Context c=this;
        Class<?> x=t;
        AlertDialog.Builder adb = new AlertDialog.Builder(this);
        adb.setMessage("Удалить пост?");
        adb.setNegativeButton("Нет", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                return;
            };
        });
        adb.setPositiveButton("Да", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                Intent intent = new Intent(c, t);
                startActivity(intent);
                finish();
            };
        });

        adb.show();
    }

    public  void ToMyProf(View view)
    {
        Cancel(MyOrgProf.class);
    }
    public  void openMenu(View view)
    {
        Cancel( MenuView.class);
    }


    public  void ToListOfOrg(View view)
    {
        Cancel(ListOfOrg.class);
    }
    public void ToLenta(View view)
    {
        Cancel(LentaActivity.class);
    }
    public void ToChats(View view)
    {
        Cancel(ListOfChats.class);
    }
}