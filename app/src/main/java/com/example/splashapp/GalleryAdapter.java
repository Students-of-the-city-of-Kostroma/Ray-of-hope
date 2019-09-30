package com.example.splashapp;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.squareup.picasso.Picasso;

import java.util.List;

public class GalleryAdapter extends RecyclerView.Adapter<GalleryAdapter.ViewHolder> {

    private List<String> Image;
    private List<String> Link;
    private Context context;


    public GalleryAdapter(Context context,List<String> Image,List<String> Link)
    {
        this.Image=Image;
        this.Link=Link;
        this.context=context;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
    {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.docs_gallery,parent,false);
        return  new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(ViewHolder  holder, int position) {
        String im=Image.get(position);
        String li=Link.get(position);

        Picasso.get().load(im).into(holder.imageView);
    }

    @Override
    public int getItemCount() {
        return Image.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder{
        public String link;
        public ImageView imageView;

        public ViewHolder (View itemView)
        {
            super(itemView);
            imageView =(ImageView) itemView.findViewById(R.id.docprev);
        }
    }
}
